<?php
namespace PHPCitation;

class Citation {
    
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function abnt() {

        $output = '';

        $data = $this->data;

        if (!empty($data['authors'])) {
            $authors = [];
            foreach ($data['authors'] as $author) {
                $authors[] = sprintf('%s, %s', mb_strtoupper($author['last_name']), $author['first_name']);
            }

            $authors = join('; ', $authors);
            $output .= $authors . '. ';
        }

        $output .= sprintf('%s. ', trim($data['title'], '. '));

        if (!empty($data['publication_title'])) {
            $output .= sprintf('<strong>%s</strong>, [s.l.], ', $data['publication_title']);
        }

        if (!empty($data['publication_volume'])) {
            $output .= sprintf('v. %s, ', $data['publication_volume']);
        }

        if (!empty($data['publication_issue'])) {
            $output .= sprintf('n. %s, ', $data['publication_issue']);
        }

        if (!empty($data['date'])) {
            $output .= sprintf('%s. ', date('Y', strtotime($data['date'])));
        }

        if (!empty($data['publication_issn'])) {
            $output .= sprintf('ISSN %s. ', $data['publication_issn']);
        }

        $output .= PHP_EOL;
        $output .= PHP_EOL;

        $output .= sprintf('%s: %s', I18n::get('Available at'), $data['url']);
        $output .= PHP_EOL;
        $output .= sprintf('%s: %s', I18n::get('Date accessed'), date('d M. Y', strtotime($data['access_date'])));

        return $output;
    }

    public function apa() {
        $output = '';
        $data = $this->data;

        if (!empty($data['authors'])) {
            $authors = [];

            foreach ($data['authors'] as $author) {
                $authors[] = sprintf('%s, %s', mb_strtoupper($author['last_name']), mb_strtoupper($author['first_name'][0]));
            }

            if (count($authors) === 1) {
                $output .= $authors . '. ';
            } else {
                $last = array_pop($authors);
                $output .= join(', ', $authors) . ' & ' . $last . '. ';
            }
        }

        if (!empty($data['date'])) {
            $time = strtotime($data['date']);
            $output .= strftime('(%G, %B)', $time) . '. ';
        }

        $output .= sprintf('%s. ', trim($data['title'], '. '));
        $output .= sprintf('<em>%s</em>, ', $data['publication_title']);

        $volume = !empty($data['publication_volume']) ? $data['publication_volume'] : '0';

        $output .= sprintf('%s(%s), ', $volume, $data['publication_issue']);

        $output .= PHP_EOL;
        $output .= PHP_EOL;
        $output .= sprintf('%s: %s ', I18n::get('Retrieved from'), $data['url']);

        return $output;

        
    }


}

