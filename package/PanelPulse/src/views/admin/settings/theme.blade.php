@extends('PanelPulse::admin.layout.header')
@section('title', 'Theme Setting | ' . env('APP_NAME'))
@section('style')
    <style>
        .admin-menu.settings {
            background-color: #eaeaea;
            border-left: 5px solid black;
            color: black;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="container mb-4">
            <div class="row">
                <div class="col-md-1">
                    <button class="btn btn-secondary" onclick="window.location.href='/admin/settings'"><i
                            class="fas fa-long-arrow-alt-left"></i></button>
                </div>
                <div class="col-md-2 p-0">
                    <table style="width:100%;height:100%">
                        <tr>
                            <td class="align-middle" style="width:100%;height:100%">
                                <h2 class="heading2">Theme Manage</h2>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-4 pt-3">
                    <h3 class="info-cont-heading mb-3">Theme Setting</h3>
                    <p class="subtext1">Manage how your store looks on frontend. </p>
                </div>
                <div class="col-8">
                    <div class="container info-cont">
                        @foreach ($theme as $theme)
                            <div class="row">
                                <div class="col-4">
                                    <table style="width:100%;height:100%">
                                        <tr>
                                            <td class="align-middle" style="width:100%;height:100%">
                                                <input type="text" value="{{ $theme->value }}" disabled
                                                    class="border-0" />
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-8">
                                    <table style="width:100%;height:100%">
                                        <tr>
                                    
                                            <td class="align-middle text-right" style="width:100%;height:100%">

                                                <button class="btn btn-secondary ml-3 open-theme-modal"
                                                    data-id="{{ $theme['id'] }}"
                                                    data-toggle="modal"
                                                    data-target="#themeModal">Set up</button>
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Theme Edit Modal -->
    <div class="modal fade" id="themeModal" tabindex="-1" role="dialog" aria-labelledby="themeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="themeModalLabel">Edit Theme Setting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="themeEditForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="theme_id">
                        <div class="form-group mb-1">
                            <label for="theme_value">Value</label>
                            <input type="text" class="form-control" id="theme_value" name="value" required>
                        </div>
                        <div id="theme_fields_container"></div>
                        <button type="button" class="btn btn-link p-0" id="add_field_btn">+ Add Field</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scriptContent')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Open modal and load data
    $('.open-theme-modal').on('click', function() {
        var themeId = $(this).data('id');
        $.get('/admin/settings/theme/json/' + themeId, function(data) {
            $('#theme_id').val(data.id);
            $('#theme_value').val(data.value);
            // Populate dynamic fields
            var fieldsHtml = '';
            if (data.fields) {
                Object.keys(data.fields).forEach(function(key) {
                    fieldsHtml += '<div class="form-group field-row">';
                    fieldsHtml += '<div class="input-group">';
                    fieldsHtml += '<input type="text" class="form-control field-key" name="field_keys[]" value="' + key + '" placeholder="Field Name" required>';
                    fieldsHtml += '<input type="text" class="form-control field-value" name="field_values[]" value="' + data.fields[key] + '" placeholder="Field Value" required>';
                    fieldsHtml += '<div class="input-group-append"><button class="btn btn-danger remove-field-btn" type="button">&times;</button></div>';
                    fieldsHtml += '</div></div>';
                });
            }
            $('#theme_fields_container').html(fieldsHtml);
        });
    });

    // Add new field row
    $('#add_field_btn').on('click', function() {
        var newField = '<div class="form-group field-row">' +
            '<div class="input-group">' +
            '<input type="text" class="form-control field-key" name="field_keys[]" placeholder="Field Name" required>' +
            '<input type="text" class="form-control field-value" name="field_values[]" placeholder="Field Value" required>' +
            '<div class="input-group-append"><button class="btn btn-danger remove-field-btn" type="button">&times;</button></div>' +
            '</div></div>';
        $('#theme_fields_container').append(newField);
    });

    // Remove field row
    $(document).on('click', '.remove-field-btn', function() {
        $(this).closest('.field-row').remove();
    });

    // Save changes via AJAX using FormData
    $('#themeEditForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData();
        formData.append('id', $('#theme_id').val());
        formData.append('value', $('#theme_value').val());
        // Gather fields as key-value pairs
        var keys = $(this).find('input[name="field_keys[]"]').map(function(){ return $(this).val(); }).get();
        var values = $(this).find('input[name="field_values[]"]').map(function(){ return $(this).val(); }).get();
        for (var i = 0; i < keys.length; i++) {
            formData.append('fields[' + keys[i] + ']', values[i]);
        }
        formData.append('_token', '{{ csrf_token() }}');
        var themeId = $('#theme_id').val();
        $.ajax({
            url: '/admin/settings/theme/update/' + themeId,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Failed to save changes');
                }
            },
            error: function() {
                alert('Error saving changes');
            }
        });
    });
});
</script>
@endsection
