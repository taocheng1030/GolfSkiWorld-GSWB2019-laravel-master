<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Form page
        \Form::component('adminInput', 'components.form.admin.input', ['name', 'value' => null, 'label' => null, 'attributes' => [], 'filedId' => null, 'maxlength' => null]);
        \Form::component('adminTextarea', 'components.form.admin.textarea', ['name', 'value' => null, 'label' => null, 'attributes' => [], 'filedId' => null]);
        \Form::component('adminDatePicker', 'components.form.admin.datePicker', ['name', 'value' => null, 'label' => null, 'attributes' => [], 'pickerId' => null, 'filedId' => null]);

        \Form::component('adminRadio', 'components.form.admin.radio', ['name', 'list' => [], 'checked' => null, 'label' => null, 'attributes' => [], 'filedId' => null]);
        \Form::component('adminMultiCheck', 'components.form.admin.multiCheck', ['name', 'list' => [], 'checked' => null, 'label' => null, 'attributes' => [], 'filedId' => null]);
        \Form::component('adminSelect', 'components.form.admin.select', ['name', 'list' => [], 'selected' => null, 'label' => null, 'attributes' => [], 'filedId' => null]);
        \Form::component('adminMultiSelect', 'components.form.admin.multiSelect', ['name', 'list' => [], 'selected' => null, 'label' => null, 'attributes' => [], 'filedId' => null]);

        \Form::component('adminUploadImage', 'components.form.admin.uploadImage', ['name', 'value' => null, 'label' => null, 'filedId' => null]);
        \Form::component('adminUploadVideo', 'components.form.admin.uploadVideo', ['name', 'value' => null, 'label' => null, 'filedId' => null]);

        \Form::component('adminCheckbox', 'components.form.admin.checkbox', ['name', 'value' => null, 'label' => null, 'attributes' => [], 'filedId' => null]);
        \Form::component('adminSubmit', 'components.form.admin.submit', ['cancel' => null, 'value' => 'Save']);
        \Form::component('adminPhoneSelect', 'components.form.admin.phoneSelect', ['name', 'value' => null, 'label' => null, 'attributes' => [], 'filedId' => null]);

        // Localized
        \Form::component('adminLocalizedInput', 'components.form.admin.localized.input', [
            'model' => null, 'languages' => [], 'name' => ['main' => null, 'lang' => null], 'value' => ['main' => null, 'lang' => null], 'label' => null, 'attributes' => ['main' => [], 'lang' => []], 'filedId' => null
        ]);
        \Form::component('adminLocalizedTextarea', 'components.form.admin.localized.textarea', [
            'model' => null, 'languages' => [], 'name' => ['main' => null, 'lang' => null], 'value' => ['main' => null, 'lang' => null], 'label' => null, 'attributes' => ['main' => [], 'lang' => []], 'filedId' => null
        ]);

        // Locale
        \Form::component('adminLocaleInput', 'components.form.admin.locale.input', [
            'model' => null, 'name' => null, 'value' => ['eng' => null, 'local' => null], 'label' => null, 'attributes' => ['eng' => [], 'local' => []], 'filedId' => null, 'maxlength' => null
        ]);
        \Form::component('adminLocaleTextarea', 'components.form.admin.locale.textarea', [
            'model' => null, 'name' => null, 'value' => ['eng' => null, 'local' => null], 'label' => null, 'attributes' => ['eng' => [], 'local' => []], 'filedId' => null, 'maxlength' => null
        ]);

        // Share page
        \Form::component('shareString', 'components.form.share.string', ['name', 'value' => null, 'label' => null, 'filedId' => null]);
        \Form::component('shareImage', 'components.form.share.image', ['name', 'value' => null, 'label' => null, 'filedId' => null]);
        \Form::component('shareVideo', 'components.form.share.video', ['name', 'value' => null, 'label' => null, 'filedId' => null]);

        // Register extended validator
        \Validator::resolver(function($translator, $data, $rules, $messages) {
            return new \App\Extensions\Validator($translator, $data, $rules, $messages);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
