<style>
    
    .hero_area_container_slide_item {
        padding-left: 12px!important;
        padding-right: 12px!important;
    }
</style>
<section class="hero_area_slider  owl-carousel">
    <?php if($homeSliders->isEmpty()): ?>
        <div class="hero_area" id='slider-1'>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 p-0">
                        <div class="hero_area_inner">
                            <img src="public\theme\edulia\img\hero-bg-1.jpg" alt="hero slider">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php $__currentLoopData = $homeSliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $homeSlider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="hero_area" id="slider-<?php echo e($index + 1); ?>">
                <div class="container-fluid hero_area_container_slide_item">
                    <div class="row">
                        <div class="col-md-12 p-0">
                            <div class="hero_area_inner">
                                <a href="<?php echo e($homeSlider->link ?? '#'); ?>" target="__blank">
                                    <img src="<?php echo e(asset($homeSlider->image)); ?>" alt="hero slider">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</section>
<?php /**PATH C:\xampp\htdocs\classai\resources\views/components/edulia/home-page-slider.blade.php ENDPATH**/ ?>