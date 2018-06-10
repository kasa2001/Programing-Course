<?php

print $this->startForm();
print "<input type='text' name='nick' value='" . $data['user']['nick']    ."'>";
print "<select name='type'>";
foreach ($data['params'] as $param) {
    if ($data['user']['type'] == $param['id'])
        print "<option selected value='" . $param['id'] . "'>" . $param['name'] . "</option>";
    else
        print "<option value='" . $param['id']. "'>" . $param['name'] . "</option>";
}
print "</select>";
print "<input type='submit'>";
print $this->endForm();