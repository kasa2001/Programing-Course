<?php
print $this->startForm();
print "<select name='idcategory'>";
foreach ($data['category'] as $course) {
    print "<option value='" . $course['id'] . "'>" . $course['name'] . "</option>";
}
print "</select>";
print "<input type='submit'/>";
print $this->endForm();

print_r($data);