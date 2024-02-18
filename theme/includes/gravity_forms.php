<?php

add_action('rest_api_init', function () {
    register_rest_route('timberstrap/v1', '/form/submit', array(
        'methods' => 'POST',
        'callback' => 'submit_to_gravity_forms',
        'permission_callback' => '__return_true',
    ));
});

function submit_to_gravity_forms($request)
{
    $params = $request->get_params();
    $json_params = $request->get_json_params();

    $form_id = isset($params['form_id']) ? (int) $params['form_id'] : null;
    $component_id = isset($params['component_id']) ? $params['component_id'] : null;

    // Prepare the submission data by excluding non-field parameters
    $submission_data = $params;
    unset($submission_data['form_id'], $submission_data['component_id']);

    // Submit the form with the correctly prepared submission data
    $result = GFAPI::submit_form($form_id, $json_params);

    if (is_wp_error($result)) {
        $response_data = [
            'error' => $result->get_error_message(),
            'submitted_params' => $submission_data,
        ];
        wp_send_json_error($response_data, 400);
        return null; // Stop further processing
    }

    if ($component_id && isset($result['is_valid']) && $result['is_valid']) {
        $string = '{{ component("' . esc_attr($component_id) . '") }}';
        $htmlContent = Timber::compile_string($string, [$component_id => $submission_data]);

        echo $htmlContent;
        exit;
    }

    wp_send_json_success($result);
    return null; // This line is not needed as wp_send_json_success exits the script
}
