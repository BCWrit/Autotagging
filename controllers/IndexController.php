<?php
/**
 * Autotagging
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

/**
 * The Autotagging index controller class.
 *
 * @package Autotagging
 */
class Autotagging_IndexController extends Omeka_Controller_AbstractActionController
{
    public function browseAction()
    {

    }

    public function autotagAction()
    {
        $start = isset($_POST['start']) ? $_POST['start'] : 0;
        $end = isset($_POST['end']) ? $_POST['end'] : 0;
        $url = isset($_POST['url']) ? $_POST['url'] : url('');

        if (isset($_POST['api_key'])) {
            $api_key = $_POST['api_key'];
        } else {
            echo "No API key provided. An API key must be provided for tagging.";
        }

        $script = "python3 /var/www/html/plugins/Autotagging/libraries/autotagging/auto_tag.py";
        $args = "{$url} {$api_key} -s {$start} -e {$end}";
        $command = "$script $args";
        $out = [];
        $status = [];
        exec($command, $out, $status);
        foreach ($out as $value) {
            echo ("$value\n");
        }
    }

    public function replacetagAction()
    {
        $start = isset($_POST['start']) ? $_POST['start'] : 0;
        $end = isset($_POST['end']) ? $_POST['end'] : 0;
        $url = isset($_POST['url']) ? $_POST['url'] : url('');
        $replacementTag = isset($_POST['replacementTag']) ? '-r ' . $_POST['replacementTag'] : '';

        if (isset($_POST['api_key'])) {
            $api_key = $_POST['api_key'];
        } else {
            echo "No API key provided. An API key must be provided for tagging.";
        }

        if (isset($_POST['currentTag'])) {
            $currentTag = $_POST['currentTag'];
        } else {
            echo "Did not provide tag to replace. This must be provided";
        }

        $script = "python3 /var/www/html/plugins/Autotagging/libraries/autotagging/replace_tag.py";
        $args = "{$url} {$api_key} {$currentTag} {$replacementTag} -s {$start} -e {$end}";
        $command = "$script $args";
        $out = [];
        $status = [];
        exec($command, $out, $status);
        foreach ($out as $value) {
            echo ("$value\n");
        }
    }
}
