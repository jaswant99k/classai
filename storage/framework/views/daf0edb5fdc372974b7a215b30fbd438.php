<?php
    $count =  pagesetting('course_count');
    $column = pagesetting('course_area_column');
    $sorting = pagesetting('course_sorting');
?>

<?php if($courses->isEmpty() && auth()->check() && auth()->user()->role_id == 1): ?>
    <p class="text-center text-danger"><?php echo app('translator')->get('edulia.no_data_available_please_go_to'); ?> <a target="_blank"
            href="<?php echo e(URL::to('/course-list')); ?>"><?php echo app('translator')->get('edulia.add_course'); ?></a></p>
<?php else: ?>
    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $color = '';
            if ($key % 4 == 1) {
                $color = 'sunset-orange';
            } elseif ($key % 4 == 2) {
                $color = 'green';
            } elseif ($key % 4 == 3) {
                $color = 'blue';
            } else {
                $color = 'orange';
            }
        ?>
        <div class="col-lg-<?php echo e($column); ?>

            <?php if($column == '12' ): ?>
                    col-md-12
                    <?php elseif($column == '6'): ?>
                    col-md-12
                    <?php elseif($column == '4'): ?>
                    col-md-6 col-sm-12
                    <?php elseif($column == '3'): ?>
                    col-md-4 col-sm-6
                    <?php elseif($column == '2'): ?>
                    col-md-3 col-sm-4 col-6
                    <?php elseif($column == '1'): ?>
                    col-md-2 col-sm-3 col-6
                <?php endif; ?>
        ">
            <a href='<?php echo e(route('frontend.course-details', $course->id)); ?>' class="course_item">
                <div class="course_item_img">
                    <div class="course_item_img_inner">
                        <img src="<?php echo e(asset($course->image)); ?>" alt="<?php echo e($course->courseCategory->category_name); ?>">
                    </div>
                    <span
                        class="course_item_img_status <?php echo e($color); ?>"><?php echo e($course->courseCategory->category_name ?? 'InfixEdu'); ?>

                    </span>
                </div>
                <div class="course_item_inner">
                    <h4><?php echo e($course->title); ?></h4>
                </div>
            </a>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div id="dynamicLoadMoreData">

    </div>

    <?php if((Request::is('/') || Request::is('home')) || Request::segment(1) == 'pages'): ?>

    <?php else: ?>
        <?php if(Request::is('course')): ?>
            <?php if($courseCount > $count): ?>
                <div class="row text-center">
                    <div class="col-md-12">
                        <div class="load_more section_padding_top">
                            <a href="#" class="site_btn load_more_course_btn" data-skip="<?php echo e($count); ?>"><?php echo e(__('edulia.load_more')); ?></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>

<?php if (! $__env->hasRenderedOnce('35adbc19-aaa1-42b8-9c97-5cd71f386398')): $__env->markAsRenderedOnce('35adbc19-aaa1-42b8-9c97-5cd71f386398');
$__env->startPush(config('pagebuilder.site_script_var')); ?>
    <script>

        $(document).on('click', '.load_more_course_btn', function (e) {
            e.preventDefault();
            var skip = $(this).data('skip');
            var take = <?php echo e($count); ?>;
            var row_each_column = <?php echo e($column); ?>;
            var sorting = "<?php echo e($sorting); ?>";

            $.ajax({
                url: "<?php echo e(route('frontend.load-more-course-list')); ?>",
                method: "POST",
                data: {
                    skip: skip,
                    row_each_column : row_each_column,
                    take : take,
                    sorting : sorting,
                    _token: "<?php echo e(csrf_token()); ?>",
                },
                success: function (response) {
                    if (response.success) {
                        $('#dynamicLoadMoreData').append(response.html);

                        $('.load_more_course_btn').data('skip', skip + take);

                        if (!response.has_more) {
                            $('.load_more_course_btn').hide();
                        }
                    } else {
                        console.error('Failed to load more photos.');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                },
            });
        });

    </script>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH C:\xampp\htdocs\classai\resources\views/components/edulia/course.blade.php ENDPATH**/ ?>