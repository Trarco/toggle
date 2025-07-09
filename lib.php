<?php

defined('MOODLE_INTERNAL') || die();

function block_toggle_filter_valid_parts(array $titles, array $subtitles = [], array $contents = []): array
{
    $filtered_titles = [];
    $filtered_subtitles = [];
    $filtered_contents = [];

    foreach ($titles as $i => $title) {
        $subtitle = $subtitles[$i] ?? '';
        $content = is_array($contents[$i] ?? '') ? ($contents[$i]['text'] ?? '') : ($contents[$i] ?? '');

        if (!empty(trim($title)) || !empty(trim($subtitle)) || !empty(trim($content))) {
            $filtered_titles[] = $title;
            $filtered_subtitles[] = $subtitle;
            $filtered_contents[] = $contents[$i] ?? '';
        }
    }

    return [$filtered_titles, $filtered_subtitles, $filtered_contents];
}
