<?php
foreach ($data['courses'] as $course):
    print "<div>";
    print $course['name'];
    print "</div>";
    print "<div>";
    print $course['datejoin'];
    print "</div>";
    print "<div>";
    print $this->buildLink('Rozpocznij test', 'user/answer/' . $course['id']);
    print "</div>";
endforeach;