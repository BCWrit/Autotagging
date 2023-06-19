<?php $title = __('Autotagging');?>
<?php echo head(array('title' => __('Autotagging'), 'bodyclass' => 'w3Page'));?>
<head>
    <script>
        window.onload = function() {
            var autotag = document.getElementById('tagging-form'); 
            autotag.onsubmit = autoTagDocuments;

            var details_expander = document.getElementById("details_expander");
            details_expander.onclick = function(e) {
                e.preventDefault();
            } 
        };

        var autoTagDocuments = function(e) {
            e.preventDefault();
            var details = document.getElementById('details');
            var start = parseInt(document.getElementById('start').value, 10);
            var end = parseInt(document.getElementById('end').value, 10);

            for (var i = start; i <= end; i++) {
                var data = {
                    'action': 'tag',
                    'start': i,
                    'end': i + 1,
                    'url': "<?php echo rtrim(absolute_url(""), "admin/") ?>",
                    'api_key': document.getElementById('api_key').value
                };
                var status = document.getElementById('status');
                status.innerHTML = '<strong>Status: In progress.</strong>';
                status.style.display = 'block';
                jQuery.post('/admin/autotagging/index/autotag', data, function (response) {
                    details.innerHTML = response;
                    status.innerHTML = '<strong>Status: Done tagging.';
                    var expander = document.getElementById('details_expander');
                    expander.style.display = 'block';
                    expander.onclick = function() {
                        if (details.style.display === 'none') {
                            details.style.display = 'block';
                        } else {
                            details.style.display = 'none';
                        }
                    };
               });
            }
        };
    </script>
</head>
<body>
    <p>
        Enter your tagging API key below. 
        Then enter a range of documents to be tagged, e.g., documents 1 through 10.
        The tagging process may take a while.
    </p>
    <form id="tagging-form">
        <input type="text" placeholder="Tagging API key" id="api_key" value="0fd084658e90da28d37fd9420e7d85cc2173c979"/>
        <input type="number" placeholder="Start ID" id="start"/>
        <input type="number" placeholder="End ID" id="end"/>
        <button id="autotag" type="submit" >Tag Documents</button> 
        <p id="status" style="display: none;"></p>
        <button id="details_expander" style="display: none;" type="button">Display Details</button>
    </form>
    <pre id="details" style="display: none;"></pre>
</body>

