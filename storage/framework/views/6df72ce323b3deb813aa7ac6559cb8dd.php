<?php if (! $__env->hasRenderedOnce('5dcec6ea-acb2-4a96-818a-9a7df36c91eb')): $__env->markAsRenderedOnce('5dcec6ea-acb2-4a96-818a-9a7df36c91eb');
$__env->startPush(config('pagebuilder.site_style_var')); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/theme/edulia/packages/carousel/owl.carousel.min.css')); ?>">
    <style>
        .home_speech_section .owl-carousel .owl-nav button, .home_speech_section .owl-carousel .owl-nav button {
            background: #ffffff;
        }
    </style>
<?php $__env->stopPush(); endif; ?>

<section class="section_padding home_speech_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section_title">
                    <span class="section_title_meta"><?php echo e(pagesetting('speech_slider_heading')); ?></span>
                    <h2><?php echo e(pagesetting('speech_slider_sub_heading')); ?></h2>
                </div>
            </div>
        </div>
        <?php if (isset($component)) { $__componentOriginal2b04c3ea6d87e8ee95f1ef75d7ebccb0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2b04c3ea6d87e8ee95f1ef75d7ebccb0 = $attributes; } ?>
<?php $component = App\View\Components\SmSpeechSlider::resolve(['count' => pagesetting('speech_slider_count')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('sm-speech-slider'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\SmSpeechSlider::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>  <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2b04c3ea6d87e8ee95f1ef75d7ebccb0)): ?>
<?php $attributes = $__attributesOriginal2b04c3ea6d87e8ee95f1ef75d7ebccb0; ?>
<?php unset($__attributesOriginal2b04c3ea6d87e8ee95f1ef75d7ebccb0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2b04c3ea6d87e8ee95f1ef75d7ebccb0)): ?>
<?php $component = $__componentOriginal2b04c3ea6d87e8ee95f1ef75d7ebccb0; ?>
<?php unset($__componentOriginal2b04c3ea6d87e8ee95f1ef75d7ebccb0); ?>
<?php endif; ?>
    </div>
</section>

<?php if (! $__env->hasRenderedOnce('a129ae68-e3e6-44e4-84ef-9a91f672a6ce')): $__env->markAsRenderedOnce('a129ae68-e3e6-44e4-84ef-9a91f672a6ce');
$__env->startPush(config('pagebuilder.site_script_var')); ?>
    <script src="<?php echo e(asset('public/theme/edulia/packages/carousel/owl.carousel.min.js')); ?>"></script>
    <script>
        $('.home_speech_section .owl-carousel').owlCarousel({
            nav: false,
            navText: ['<i class="far fa-angle-left"></i>', '<i class="far fa-angle-right"></i>'],
            dots: false,
            items: 3,
            loop: true,
            margin: 20,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            responsive:{
                0: {
                    items: 1,
                    nav: false,
                },
                576:{
                    nav: true,
                    items: 1,
                },
                767:{
                    items: 2,
                },
                991:{
                    items: 3,
                },
            }
        });
    </script>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH C:\xampp\htdocs\classai\resources\views/themes/edulia/pagebuilder/speech-slider/view.blade.php ENDPATH**/ ?>