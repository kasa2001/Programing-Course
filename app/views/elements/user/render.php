<?php
print "<div>";
print "<span>";
print "id ";
print "</span>";
print "<span>";
print "właściciel ";
print "</span>";
print "<span>";
print "użytownik ";
print "</span>";
print "<span>";
print "data dołączenia ";
print "</span>";
print "</div>";
foreach ($data['report'] as $report) {
    print "<div>";
    foreach ($report as $field) {
        print "<span>";
        print $field;
        print " </span>";
    }
    print "</div>";
}