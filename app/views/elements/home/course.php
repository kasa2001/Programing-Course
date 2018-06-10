<div class="course">
    <?php
    print_r($data['courses']);
    ?>

    <?php if (key_exists(0, $data['courses'])): ?>
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
    <?php else: ?>
        <div class="course-item">
            <p class="course-id">
                <?= $data['courses']['id'] ?>
            </p>
            <p class="course-employer">
                <?= $data['courses']['employer']?>
            </p>
            <?= $this->buildLink("Zapisz się", "user/add/" . $data['courses']['id'], ['course-link'])?>
        </div>
    <?php endif ?>
</div>
