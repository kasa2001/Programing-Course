<?php

namespace Modules\Built\Pagination;

use Lib\Built\Error\Error;
use Lib\Built\URI\URI;

class Pagination
{
    private $limit;
    private $display;
    private $total;
    private $current;
    private $start;
    private $end;

    /**
     * @var  $uri URI
     * */
    private $uri;

    public function __construct($limit, $display, $total)
    {
        $this->uri = URI::getInstance(null);
        $this->current = $this->uri->getCurrentPage();
        if ($this->current % $limit != 0 || $this->current > $total || $this->current < 0) {
            Error::raiseError(404);
        }
        $this->limit = $limit;
        $this->display = $display;
        $this->total = $total;
        $this->_setDisplay($limit * floor(($display / 2)), $limit * ceil($display / 2));
    }

    private function _setDisplay($start, $end)
    {
        if (($this->current - $start) < 0) {
            $this->start = 0;
        } else {
            $this->start = $this->current - $start;
        }

        if ($this->current + $end > $this->total) {
            $this->end = $this->total;
        } else {
            $this->end = $this->current + $end;
        }
    }

    protected function _inactive($title)
    {
        return "<p>$title</p>";
    }

    protected function _active($link, $title, $visible)
    {
        if ($visible) {
            return '<a href="' . $link . '"> ' . $title . '</a>';
        }
        return '<a href="' . $link . '" class="hidden-xs"> ' . $title . '</a>';
    }

    protected function _checkActive($link, $title)
    {
        if ('/'.$link != $this->uri->getRequestURI() && (($this->start) != 0 || $this->current != 0)) {
            return $this->_active($link, $title, false);
        }

        return $this->_inactive($title);
    }

    public function __toString()
    {
        $link = $this->uri->toPagination();
        $html = '<nav class="pagination">';

        if (($this->start - $this->limit) > 0) {
            $html .= $this->_active($link, 1, true);
        }

        for ($i = 0; $i < $this->display; $i++) {

            $html .= $this->_checkActive($link . $this->start, (($this->start / $this->limit) + 1));

            $this->start += $this->limit;

            if ($this->start >= $this->total) {
                break;
            }
        }

        if ($this->start + $this->limit < $this->total) {
            $html .= $this->_active($link . (floor($this->total / $this->limit) * $this->limit), ceil($this->total / $this->limit), true);
        }

        $html .= '</nav>';

        return $html;
    }

    public function addRelation()
    {

    }
}
