<?php
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

        $this->repeat_elements(
            $repeatarray,
            3,
            [],
            'config_part_repeat_count',
            'config_part_repeat_add',
            1,
            get_string('addpart', 'block_toggle')
        );
    }
}
