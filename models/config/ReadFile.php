<?php

namespace app\models\config;

use app\models\MessageErrors;
use SplFileObject;
use function Couchbase\basicEncoderV1;

class ReadFile
{
    private $file;
    private $page;
    private $records;
    private $data;

    private $spl;


    public function __construct($file, $page, $records, $data){
        $this->file = $file;
        $this->page = (int) $page;
        $this->records = $records;
        $this->data = $data;
        $this->spl = $this->getSpl();
    }

    function readTheFile (): \Generator
    {
        $i = 0;
        if (empty($this->data['code']) && empty($this->data['date'])) {
            $line = ($this->page * $this->records) - $this->records;
            if ($line > 0) {
                $this->spl->seek($line);
            }
            while (!$this->spl->eof()) {
                $i++;
                if ($i > $this->records) break;
                yield json_decode($this->spl->current(), true);
                $this->spl->next();
            }
        } else {
            $skip = ($this->page - 1) * $this->records;
            while(!$this->spl->eof() && $this->records > $i) {
                $item = json_decode($this->spl->current(), true);
                if ($this->dataValid($item) === true) {
                    if ($skip) {
                        $skip--;
                    } else {
                        yield $item;
                        $i++;
                    }
                }
                $this->spl->next();
            }
        }
    }

    function dataValid($item) {
        $code = (!empty($item['code']) && $item['code'] == $this->data['code']);
        $date = (!empty($item['date']) && $item['date'] == $this->data['date']);
        switch (true) {
            case ($date && empty($this->data['code'])):
            case ($code):
            case ($date && $code): return true;
            default: return false;
        }
    }

    function getCount() {
        $c = 0;
        $spl = $this->getSpl();
        if (empty($this->data['date']) && empty($this->data['code'])) {
            $spl->seek(PHP_INT_MAX);
            $c = $spl->key();
        } else {
            while (!$spl->eof()) {
                $item = json_decode($spl->current(), 1);
                if ($this->dataValid($item)) {
                    $c++;
                }
                $spl->next();
            }
        }
        $spl->rewind();
        return $c;
    }

    private function getSpl(): SplFileObject {
        if ($this->spl === null) {
            $this->spl = new SplFileObject($this->file);
        }
        return $this->spl;
    }
}


