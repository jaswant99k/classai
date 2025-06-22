<?php if(!empty($page->settings['grids'])): ?>

    <?php $__currentLoopData = $page->settings['grids']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $columns = getColumnInfo($grid['grid']);
            setGridId($grid['grid_id']);
            $css = getCss();
            if (!empty(getBgOverlay())) {
                $css = 'position:relative;' . $css;
            }

            $x_components = ['header-breadcumb', 'home-slider', 'counter', 'event', 'news-area', 'event-gallery', 'app-banner', 'news-section'];
            $non_container = ['opening-hour','contact-form','google-map','speech','cta','faqs'];

            $isNonContainer = false;
            
            if (isset($grid['data'])) {
                foreach ($grid['data'] as $dataColumn) {
                    foreach ($dataColumn as $component) {
                        if (in_array($component['section_id'], $non_container)) {
                            $isNonContainer = true;
                            break 2;
                        }
                    }
                }
            }
        ?>

        <section class="pb-themesection <?php echo e(getClasses()); ?>" <?php echo getCustomAttributes(); ?> <?php echo !empty($css) ? 'style="' . $css . '"' : ''; ?>>
            <?php echo getBgOverlay(); ?>

            
            <?php if($isNonContainer): ?>
                <div <?php echo getContainerStyles(); ?>>
            <?php endif; ?>

            <div class="<?php echo e($isNonContainer ? 'full-width' : 'container-fluid'); ?>">
                <div class="row droppable-container" data-id="<?php echo e($grid['grid_id']); ?>">
                    <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $columnIndex => $columnClass): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="<?php echo e($columnClass); ?> p-0">
                            <?php $__currentLoopData = $grid['data'][$columnIndex] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    setSectionId($component['id']);
                                    $isXComponent = in_array($component['section_id'], $x_components);
                                ?>

                                <div class="<?php echo e($isXComponent ? 'full-width' : ''); ?>" >
                                    <?php if(view()->exists('themes.' . activeTheme() . '.pagebuilder.' . $component['section_id'] . '.view')): ?>
                                        <?php echo view('themes.' . activeTheme() . '.pagebuilder.' . $component['section_id'] . '.view')->render(); ?>

                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <?php if($isNonContainer): ?>
                </div>
            <?php endif; ?>
        </section>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\classai\packages\larabuild\pagebuilder\src/../resources/views/components/page-components.blade.php ENDPATH**/ ?>