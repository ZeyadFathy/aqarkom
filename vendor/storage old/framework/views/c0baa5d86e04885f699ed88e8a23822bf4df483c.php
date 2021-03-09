<div class="<?php echo e($viewClass['form-group'], false); ?> <?php echo !$errors->has($errorKey) ? '' : 'has-error'; ?>">

    <label for="<?php echo e($id['lat'], false); ?>" class="<?php echo e($viewClass['label'], false); ?> control-label"><?php echo e($label, false); ?></label>

    <div class="<?php echo e($viewClass['field'], false); ?>">

        <?php echo $__env->make('admin::form.error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div id="map_<?php echo e($id['lat'].$id['lng'], false); ?>" style="width: 100%;height: 300px"></div>
        <input type="hidden" id="<?php echo e($id['lat'], false); ?>" name="<?php echo e($name['lat'], false); ?>" value="<?php echo e(old($column['lat'], $value['lat']), false); ?>" <?php echo $attributes; ?> />
        <input type="hidden" id="<?php echo e($id['lng'], false); ?>" name="<?php echo e($name['lng'], false); ?>" value="<?php echo e(old($column['lng'], $value['lng']), false); ?>" <?php echo $attributes; ?> />

        <?php echo $__env->make('admin::form.help-block', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    </div>
</div>
