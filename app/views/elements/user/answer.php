<?php
print $this->startForm('user/answer/' . $data['courseid'] . '/' . $data['next']);
print "<div>";
print $data['question']['quest'];
print "</div>";

if ($data['answers']) {
    print '<select name="answer">';

    foreach ($data['answers'] as $answer) {
        print '<option value="' . $answer['id'] . '">';
        print $answer['name'];
        print '</option>';
    }

    print '</select>';
} else {
    print '<textarea name="answer" placeholder="Wstaw tutaj kod">';
    print '</textarea>';
}
print '<input type="submit">';
print '<input type="hidden" name="idquestion" value="' . $data['question']['id'] . '">';
print $this->endForm();

print "<pre>";
print_r($data);
print "</pre>";