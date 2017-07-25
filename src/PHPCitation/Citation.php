<?php
namespace PHPCitation;

class Citation {
    
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function getVolume() {
        return !empty($data['publication_volume']) ? $data['publication_volume'] : '0';
    }

    public function getTitle() {
        return trim($this->data['title'], '. ');
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
        $output .= sprintf('%s %s ', I18n::get('Retrieved from'), $data['url']);

        return $output;

        
    }

    public static function join($array, $separator = ', ', $lastSeparator = ' and ') {
        $last  = array_slice($array, -1);
        $first = join($separator, array_slice($array, 0, -1));
        $both  = array_filter(array_merge(array($first), $last), 'strlen');
        return join($lastSeparator, $both);
    }

    public function bibtex() {
        $data = $this->data;
        $time = strtotime($data['date']);

        $authors = array_map(function($author) {
            return sprintf('%s %s', $author['first_name'], mb_strtoupper($author['last_name']));
        }, $data['authors']);

        $authors = self::join($authors);

        return sprintf('
                @%s{%s,
                    author = {%s},
                    title = {%s},
                    journal = {%s},
                    volume = {%s},
                    number = {%s},
                    year = {%s},
                    keywords = {},
                    abstract = {%s},
                    issn = {%s},
                    url = {%s}
                }
            ',
            $data['type'],
            $data['label'],
            $authors,
            trim($data['title'], '. '),
            $data['publication_title'],
            !empty($data['publication_volume']) ? $data['publication_volume'] : '0',
            $data['publication_issue'],
            date('Y', $time),
            $data['abstract'],
            $data['publication_issn'],
            $data['url']
        );
        
    }

    public function cbe() {
        $output = '';
        $data = $this->data;
        $time = strtotime($data['date']);

        $authors = array_map(function($author) {
            return sprintf('%s %s', $author['last_name'], mb_strtoupper($author['first_name'][0]));
        }, $data['authors']);

        $authors = self::join($authors, ', ', ', ');

        $output .= sprintf('%s. ', $authors);

        $output .= sprintf('%s. ', $this->getTitle());
        $output .= sprintf('%s [%s] ', $data['publication_title'], $data['cbe_type']);
        
        $output .= strftime('(%G %b %e); ', $time);

        $output .= sprintf('%s(%s).', $this->getVolume(), $data['publication_issue']);
    
        return $output;

    }

    public function mla() {
        $output = '';
        $data = $this->data;
        $time = strtotime($data['date']);

        $authors = $data['authors'];

        // @link: http://sites.umuc.edu/library/libhow/mla_examples.cfm#authors
        if (count($authors) === 1) {
            $output .= sprintf('%s, %s. ', $authors[0]['last_name'], $authors[0]['first_name']);
        } else if (count($authors) === 2) {
            $output .= sprintf('%s, %s, and', $authors[0]['last_name'], $authors[0]['first_name']);
            $output .= sprintf('%s %s. ', $authors[1]['first_name'], $authors[1]['last_name']);
        } else if (count($authors) >= 3) {
            $output .= sprintf('%s, %s, et al. ', $authors[0]['last_name'], $authors[0]['first_name']);
        }

        $output .= sprintf('"%s" ', $this->getTitle());
        $output .= sprintf('<em>%s</em>, ', $data['publication_title']);
        $output .= sprintf('vol. %s, no. %s, ', $this->getVolume(), $data['publication_issue']);
        $output .= date('Y. ', $time);
        
        return $output;
    }

}

