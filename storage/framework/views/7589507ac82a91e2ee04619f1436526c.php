<style>
    .photo-gallery-image {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2; 
        -webkit-box-orient: vertical;
    }
</style>

<div class="row mb-minus-24">
    <?php
        $photoGalleryCount = $photoGalleries->count();
        $isAdmin = auth()->check() && auth()->user()->role_id == 1;
        $count =  pagesetting('photo_gallery_count');
    ?>
    <?php if($photoGalleryCount < 1 && $isAdmin): ?>
        <p class="text-center text-danger"><?php echo app('translator')->get('edulia.no_data_available_please_go_to'); ?> <a target="_blank" href="<?php echo e(URL::to('/photo-gallery')); ?>"><?php echo app('translator')->get('edulia.photo_gallery'); ?></a></p>
    <?php else: ?>
    <?php $__currentLoopData = $photoGalleries->take((int) $count); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photoGallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="totalblog col-lg-<?php echo e($column); ?> 
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
            " id="<?php echo e(@$column); ?>">
                <a href='<?php echo e(route('frontend.gallery-details', $photoGallery->id)); ?>' class="gallery_item">
                    <div class="gallery_item_img">
                        <img src="<?php echo e(asset($photoGallery->feature_image)); ?>" alt="">
                    </div>
                    <div class="gallery_item_inner">
                        <h4 class="photo-gallery-image"><?php echo e($photoGallery->name); ?></h4>
                    </div>
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div id="dynamicLoadMoreData">

        </div>

        <?php if((Request::is('/') || Request::is('home')) || Request::segment(1) == 'pages'): ?>

        <?php else: ?>
            <?php if(Request::is('gallery')): ?>
                <?php if($photoGalleryCount > $count): ?>
                    <div class="row text-center">
                        <div class="col-md-12">
                            <div class="load_more section_padding_top">
                                <a href="#" class="site_btn load_more_photo_btn" data-skip="<?php echo e($count); ?>"><?php echo e(__('edulia.load_more')); ?></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php if (! $__env->hasRenderedOnce('d11f85f6-8a34-4fb6-b482-65f8dfcfaf0b')): $__env->markAsRenderedOnce('d11f85f6-8a34-4fb6-b482-65f8dfcfaf0b');
$__env->startPush(config('pagebuilder.site_script_var')); ?>
    <script>

        $(document).on('click', '.load_more_photo_btn', function (e) {
            e.preventDefault();
            var skip = $(this).data('skip');
            var take = <?php echo e($count); ?>;
            var row_each_column = <?php echo e($column); ?>;

            $.ajax({
                url: "<?php echo e(route('frontend.load-more-photo-gallery-list')); ?>",
                method: "POST",
                data: {
                    skip: skip,
                    row_each_column : row_each_column,
                    take : take,
                    _token: "<?php echo e(csrf_token()); ?>",
                },
                success: function (response) {
                    if (response.success) {
                        $('#dynamicLoadMoreData').append(response.html);

                        $('.load_more_photo_btn').data('skip', skip + take);

                        if (!response.has_more) {
                            $('.load_more_photo_btn').hide();
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
<?php $__env->stopPush(); endif; ?><?php /**PATH C:\xampp\htdocs\classai\resources\views/components/edulia/photo-gallery.blade.php ENDPATH**/ ?>