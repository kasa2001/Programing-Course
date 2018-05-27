<div class="course">
    <?php foreach ($data['courses'] as $course): ?>
    <div class="course-item">
        <p class="course-id">
            <?= $course['id'] ?>
        </p>
        <p class="course-employer">
            <?=$course['employer']?>
        </p>
        <?= $this->buildLink("Zapisz się", "user/add/" . $course['id'], ['course-link'])?>
    </div>
    <?php endforeach ?>
</div>
