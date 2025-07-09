<?php
class block_toggle extends block_base
{
    public function init()
    {
        $this->title = get_string('pluginname', 'block_toggle');
    }

    public function applicable_formats()
    {
        return [
            'course-view' => true,
            'mod' => false,
            'my' => false
        ];
    }

    public function allow_multiple_instances()
    {
        return true;
    }

    public function has_config()
    {
        return false;
    }

    public function get_content()
    {
        global $PAGE, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $PAGE->requires->css('/blocks/toggle/styles.css');

        $parts = [];

        if (!empty($this->config->part_title) && is_array($this->config->part_title)) {

            foreach ($this->config->part_title as $i => $title) {

                $subtitle = $this->config->part_subtitle[$i] ?? '';

                $rawcontent = is_array($this->config->part_editor[$i])
                    ? $this->config->part_editor[$i]['text'] ?? ''
                    : $this->config->part_editor[$i];

                $parsedContent = [];
                $lines = preg_split('/\r\n|\r|\n/', $rawcontent);
                $currentMain = null;
                $currentSublist = [];

                foreach ($lines as $line) {
                    $trimmed = trim($line);
                    if ($trimmed === '') {
                        continue;
                    }

                    if (str_starts_with($trimmed, '-')) {
                        // Riga con "-" → subitem
                        $subitem = trim(ltrim($trimmed, '-'));
                        $currentSublist[] = $subitem;
                    } else {
                        // Se stavamo costruendo una sub-lista, la salviamo prima di creare un nuovo item
                        if (!empty($currentSublist) && $currentMain !== null) {
                            $parsedContent[$currentMain]['subitems'][] = $currentSublist;
                            $currentSublist = [];
                        }

                        // Nuovo item principale
                        $currentMain = count($parsedContent);
                        $parsedContent[$currentMain] = [
                            'text' => $trimmed,
                            'subitems' => []  // array di array
                        ];
                    }
                }

                // Se ci sono subitem rimasti dopo l'ultima riga, li aggiungiamo
                if (!empty($currentSublist) && $currentMain !== null) {
                    $parsedContent[$currentMain]['subitems'][] = $currentSublist;
                }

                $parts[] = (object)[
                    'title' => $title,
                    'subtitle' => $subtitle,
                    'contentitems' => array_values($parsedContent)
                ];
            }
        }

        $renderable = new \stdClass();
        $renderable->blocktitle = $this->config->blocktitle ?? '';
        $renderable->blockcontent = $this->config->blockcontent['text'] ?? '';
        $renderable->parts = $parts;

        $this->content = new \stdClass();
        $this->content->text = $OUTPUT->render_from_template('block_toggle/content', $renderable);
        $this->content->footer = '';

        return $this->content;
    }
}
