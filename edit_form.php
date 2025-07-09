<?php
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/toggle/lib.php');

class block_toggle_edit_form extends block_edit_form
{

    protected function specific_definition($mform)
    {
        // 🔹 Campi generali del blocco
        $mform->addElement('text', 'config_blocktitle', get_string('blocktitle', 'block_toggle'));
        $mform->setType('config_blocktitle', PARAM_TEXT);
        $mform->setDefault('config_blocktitle', get_string('defaultblocktitle', 'block_toggle'));


        $mform->addElement('editor', 'config_blockcontent', get_string('blockcontent', 'block_toggle'));
        $mform->setDefault('config_blockcontent', [
            'text' => get_string('defaultblockcontent', 'block_toggle'),
            'format' => FORMAT_HTML
        ]);

        // 🔹 Gruppo ripetibile per le parti della giornata
        $repeatarray = [];

        $repeatarray[] = $mform->createElement('text', 'config_part_title', get_string('parttitle', 'block_toggle'));
        $mform->setType('config_part_title', PARAM_TEXT);

        $repeatarray[] = $mform->createElement('text', 'config_part_subtitle', get_string('partsubtitle', 'block_toggle'));
        $mform->setType('config_part_subtitle', PARAM_TEXT);


        $repeatarray[] = $mform->createElement('textarea', 'config_part_editor', get_string('partcontent', 'block_toggle'), 'wrap="virtual" rows="5" cols="60"');
        $mform->setType('config_part_editor', PARAM_TEXT);

        // 🔹 Gruppo ripetibile per le parti della giornata
        $repeatarray = [];

        $repeatarray[] = $mform->createElement('text', 'config_part_title', get_string('parttitle', 'block_toggle'));
        $mform->setType('config_part_title', PARAM_TEXT);

        $repeatarray[] = $mform->createElement('text', 'config_part_subtitle', get_string('partsubtitle', 'block_toggle'));
        $mform->setType('config_part_subtitle', PARAM_TEXT);

        $repeatarray[] = $mform->createElement('textarea', 'config_part_editor', get_string('partcontent', 'block_toggle'), 'wrap="virtual" rows="5" cols="60"');
        $mform->setType('config_part_editor', PARAM_TEXT);

        // 🔹 Calcolo del numero di ripetizioni da mostrare
        $defaulttitles = isset($this->block->config->part_title) && is_array($this->block->config->part_title)
            ? $this->block->config->part_title
            : [];

        $defaultsubtitles = isset($this->block->config->part_subtitle) && is_array($this->block->config->part_subtitle)
            ? $this->block->config->part_subtitle
            : [];

        $defaultcontents = isset($this->block->config->part_editor) && is_array($this->block->config->part_editor)
            ? $this->block->config->part_editor
            : [];

        $validcount = 0;

        foreach ($defaulttitles as $i => $title) {
            $subtitle = $defaultsubtitles[$i] ?? '';
            $content = is_array($defaultcontents[$i] ?? '') ? ($defaultcontents[$i]['text'] ?? '') : ($defaultcontents[$i] ?? '');

            if (!empty(trim($title)) || !empty(trim($subtitle)) || !empty(trim($content))) {
                $validcount++;
            }
        }

        $repeatcount = max(3, $validcount);
        $this->repeat_elements(
            $repeatarray,
            $repeatcount,
            [],
            'config_part_repeat_count',
            'config_part_repeat_add',
            1,
            get_string('addpart', 'block_toggle')
        );
    }

    public function set_data($data)
    {
        if (!empty($data->config_part_title)) {
            list($titles, $subtitles, $contents) = block_toggle_filter_valid_parts(
                $data->config_part_title,
                $data->config_part_subtitle ?? [],
                $data->config_part_editor ?? []
            );

            $data->config_part_title = $titles;
            $data->config_part_subtitle = $subtitles;
            $data->config_part_editor = $contents;
        }

        parent::set_data($data);
    }

    public function get_data()
    {
        $data = parent::get_data();

        if ($data && !empty($data->config_part_title)) {
            list($titles, $subtitles, $contents) = block_toggle_filter_valid_parts(
                $data->config_part_title,
                $data->config_part_subtitle ?? [],
                $data->config_part_editor ?? []
            );

            $data->config_part_title = $titles;
            $data->config_part_subtitle = $subtitles;
            $data->config_part_editor = $contents;
        }

        return $data;
    }
}
