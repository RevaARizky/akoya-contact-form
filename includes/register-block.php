<?php

add_action('wpcf7_init', 'registerBlock');

function registerBlock() {
    wpcf7_add_form_tag(
        array('treatmentnonce', 'treatmentnonce*'),
        'treatmentNonceFormTagHandler',
        array('name-attr' => true)
    );
    wpcf7_add_form_tag(
        array('treatmentdate', 'treatmentdate*'),
        'treatmentDateFormTagHandler',
        array('name-attr' => true)
    );
    wpcf7_add_form_tag(
        array('treatmenthour', 'treatmenthour*'),
        'treatmentHourFormTagHandler',
        array('name-attr' => true)
    );
    wpcf7_add_form_tag(
        array('treatmentservice', 'treatmentservice*'),
        'treatmentServiceFormTagHandler',
        array('name-attr' => true)
    );
    wpcf7_add_form_tag(
        array('treatmentconfirm', 'treatmentconfirm*'),
        'treatmentConfirmFormTagHandler',
        array('name-attr' => true)
    );
    wpcf7_add_form_tag(
        array('treatmentpackage', 'treatmentpackage*'),
        'treatmentPackageFormTagHandler',
        array('name-attr' => true)
    );
    wpcf7_add_form_tag(
        array('treatmentdiscount', 'treatmentdiscount*'),
        'treatmentDiscountFormTagHandler',
        array('name-attr' => true)
    );
}

function treatmentNonceFormTagHandler() {
    $nonce = WPSimpleNonce::createNonce('reservation');

    $html = '<input type="hidden" name="treatmentnoncename" value="'. $nonce['name'] .'">';
    $html .= '<input type="hidden" name="treatmentnoncevalue" value="'. $nonce['value'] .'">';

    return $html;
}

function treatmentConfirmFormTagHandler($tag) {
    if(empty($tag->name)) {
        return '';
    }

    $html = '
        <div class="flex confirm-wrapper ml-8">
            <div class="confirm flex mr-2 items-center cursor-pointer">
                <div class="icon-check">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="20" viewBox="0 0 19 20" fill="none">
                        <path d="M16.625 4.875C16.625 3.77043 15.7296 2.875 14.625 2.875H4.375C3.27043 2.875 2.375 3.77043 2.375 4.875V15.125C2.375 16.2296 3.27043 17.125 4.375 17.125H14.625C15.7296 17.125 16.625 16.2296 16.625 15.125V4.875Z" fill="#BF9270"/>
                        <path d="M7.91634 13.9582L3.95801 9.99982L5.07426 8.88357L7.91634 11.7177L13.9251 5.70898L15.0413 6.83315L7.91634 13.9582Z" fill="white"/>
                    </svg>
                </div>
                <div class="icon-uncheck">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="20" viewBox="0 0 19 20" fill="none">
                        <path d="M14.625 3.875C15.1773 3.875 15.625 4.32272 15.625 4.875V15.125C15.625 15.6773 15.1773 16.125 14.625 16.125H4.375C3.82272 16.125 3.375 15.6773 3.375 15.125V4.875C3.375 4.32272 3.82272 3.875 4.375 3.875H14.625Z" stroke="#AAAAAA" stroke-width="2"/>
                    </svg>
                </div>
                <label>Yes</label>
                <input type="radio" name="'.esc_attr($tag->name).'" class="hidden" value="yes">
            </div>
            <div class="confirm flex active items-center cursor-pointer">
                <div class="icon-check">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="20" viewBox="0 0 19 20" fill="none">
                        <path d="M16.625 4.875C16.625 3.77043 15.7296 2.875 14.625 2.875H4.375C3.27043 2.875 2.375 3.77043 2.375 4.875V15.125C2.375 16.2296 3.27043 17.125 4.375 17.125H14.625C15.7296 17.125 16.625 16.2296 16.625 15.125V4.875Z" fill="#BF9270"/>
                        <path d="M7.91634 13.9582L3.95801 9.99982L5.07426 8.88357L7.91634 11.7177L13.9251 5.70898L15.0413 6.83315L7.91634 13.9582Z" fill="white"/>
                    </svg>
                </div>
                <div class="icon-uncheck">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="20" viewBox="0 0 19 20" fill="none">
                        <path d="M14.625 3.875C15.1773 3.875 15.625 4.32272 15.625 4.875V15.125C15.625 15.6773 15.1773 16.125 14.625 16.125H4.375C3.82272 16.125 3.375 15.6773 3.375 15.125V4.875C3.375 4.32272 3.82272 3.875 4.375 3.875H14.625Z" stroke="#AAAAAA" stroke-width="2"/>
                    </svg>
                </div>
                <label>No</label>
                <input type="radio" name="'.esc_attr($tag->name).'" class="hidden" checked="checked" value="no">
            </div>
        </div>
        ';
        // var_dump($html);
    return $html;
}


function treatmentServiceFormTagHandler($tag) {
    if(empty($tag->name)) {
        return '';
    }

    // var_dump(WP_SITEURL);
    if(!isset($_POST['treatment']) || !isset($_POST['price'])) {
        // header('Location: http://localhost/treatments');
        // wp_redirect('/treatment');
        // exit;
        // wp_die();
    }

    $html = sprintf(
        '<input type="hidden" id="service-select" class="hidden" name="treatservice" value="%1$s">
        <input type="hidden" id="price-select" class="hidden" name="treatprice" value="%2$s">',
        esc_attr(rawurldecode($_POST['treatment'])),
        esc_attr(rawurldecode($_POST['price']))
    );
    return $html;
}

function treatmentDateFormTagHandler( $tag ) {
    if ( empty( $tag->name ) ) {
		return '';
	}

    $html = sprintf(
		'<div class="col-span-2 md:col-span-1 md:px-16 px-8 relative">
        <div class="input-wrapper relative">
            <div class="icon-wrapper absolute top-1/2 left-[5px] -translate-y-1/2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <g clip-path="url(#clip0_411_3510)">
                        <path d="M8.2 9.6C7.97333 9.6 7.78347 9.5232 7.6304 9.3696C7.4768 9.21653 7.4 9.02667 7.4 8.8C7.4 8.57333 7.4768 8.3832 7.6304 8.2296C7.78347 8.07653 7.97333 8 8.2 8C8.42667 8 8.6168 8.07653 8.7704 8.2296C8.92347 8.3832 9 8.57333 9 8.8C9 9.02667 8.92347 9.21653 8.7704 9.3696C8.6168 9.5232 8.42667 9.6 8.2 9.6ZM5 9.6C4.77333 9.6 4.5832 9.5232 4.4296 9.3696C4.27653 9.21653 4.2 9.02667 4.2 8.8C4.2 8.57333 4.27653 8.3832 4.4296 8.2296C4.5832 8.07653 4.77333 8 5 8C5.22667 8 5.4168 8.07653 5.5704 8.2296C5.72347 8.3832 5.8 8.57333 5.8 8.8C5.8 9.02667 5.72347 9.21653 5.5704 9.3696C5.4168 9.5232 5.22667 9.6 5 9.6ZM11.4 9.6C11.1733 9.6 10.9835 9.5232 10.8304 9.3696C10.6768 9.21653 10.6 9.02667 10.6 8.8C10.6 8.57333 10.6768 8.3832 10.8304 8.2296C10.9835 8.07653 11.1733 8 11.4 8C11.6267 8 11.8165 8.07653 11.9696 8.2296C12.1232 8.3832 12.2 8.57333 12.2 8.8C12.2 9.02667 12.1232 9.21653 11.9696 9.3696C11.8165 9.5232 11.6267 9.6 11.4 9.6ZM8.2 12.8C7.97333 12.8 7.78347 12.7232 7.6304 12.5696C7.4768 12.4165 7.4 12.2267 7.4 12C7.4 11.7733 7.4768 11.5835 7.6304 11.4304C7.78347 11.2768 7.97333 11.2 8.2 11.2C8.42667 11.2 8.6168 11.2768 8.7704 11.4304C8.92347 11.5835 9 11.7733 9 12C9 12.2267 8.92347 12.4165 8.7704 12.5696C8.6168 12.7232 8.42667 12.8 8.2 12.8ZM5 12.8C4.77333 12.8 4.5832 12.7232 4.4296 12.5696C4.27653 12.4165 4.2 12.2267 4.2 12C4.2 11.7733 4.27653 11.5835 4.4296 11.4304C4.5832 11.2768 4.77333 11.2 5 11.2C5.22667 11.2 5.4168 11.2768 5.5704 11.4304C5.72347 11.5835 5.8 11.7733 5.8 12C5.8 12.2267 5.72347 12.4165 5.5704 12.5696C5.4168 12.7232 5.22667 12.8 5 12.8ZM11.4 12.8C11.1733 12.8 10.9835 12.7232 10.8304 12.5696C10.6768 12.4165 10.6 12.2267 10.6 12C10.6 11.7733 10.6768 11.5835 10.8304 11.4304C10.9835 11.2768 11.1733 11.2 11.4 11.2C11.6267 11.2 11.8165 11.2768 11.9696 11.4304C12.1232 11.5835 12.2 11.7733 12.2 12C12.2 12.2267 12.1232 12.4165 11.9696 12.5696C11.8165 12.7232 11.6267 12.8 11.4 12.8ZM2.6 16C2.16 16 1.7832 15.8435 1.4696 15.5304C1.15653 15.2168 1 14.84 1 14.4V3.2C1 2.76 1.15653 2.38347 1.4696 2.0704C1.7832 1.7568 2.16 1.6 2.6 1.6H3.4V0H5V1.6H11.4V0H13V1.6H13.8C14.24 1.6 14.6168 1.7568 14.9304 2.0704C15.2435 2.38347 15.4 2.76 15.4 3.2V14.4C15.4 14.84 15.2435 15.2168 14.9304 15.5304C14.6168 15.8435 14.24 16 13.8 16H2.6ZM2.6 14.4H13.8V6.4H2.6V14.4Z" fill="#AAAAAA"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_411_3510">
                        <rect width="16" height="16" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
            </div>
            <input id="calendar-select" type="date" name="%1$s" class="w-full pl-8 text-xl" style="border: 0; border-bottom: 1px solid #E2E4E5;">
        </div>
        <div class="calendar-container w-full mt-8">
            <header class="calendar-header">
                <div class="calendar-navigation flex justify-between items-center w-full">
                    <span id="calendar-prev" class="flex justify-center items-center cf7custom-hide-nav">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                            <path d="M11.7265 12.5L12.6665 11.56L9.61317 8.5L12.6665 5.44L11.7265 4.5L7.7265 8.5L11.7265 12.5Z" fill="black"/>
                            <path d="M7.33344 12.5L8.27344 11.56L5.2201 8.5L8.27344 5.44L7.33344 4.5L3.33344 8.5L7.33344 12.5Z" fill="black"/>
                        </svg>
                    </span>
                    <p class="calendar-current-date mb-0 text-center"></p>
                    <span id="calendar-next" class="flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                            <path d="M4.2735 4.5L3.3335 5.44L6.38683 8.5L3.3335 11.56L4.2735 12.5L8.2735 8.5L4.2735 4.5Z" fill="black"/>
                            <path d="M8.66656 4.5L7.72656 5.44L10.7799 8.5L7.72656 11.56L8.66656 12.5L12.6666 8.5L8.66656 4.5Z" fill="black"/>
                        </svg>
                    </span>
                </div>
            </header>
            <div class="calendar-body">
                <ul class="calendar-weekdays pl-0">
                    <li>Sun</li>
                    <li>Mon</li>
                    <li>Tue</li>
                    <li>Wed</li>
                    <li>Thu</li>
                    <li>Fri</li>
                    <li>Sat</li>
                </ul>
                <ul class="calendar-dates pl-0"></ul>
            </div>
        </div>
        </div>',
		esc_attr( $tag->name )
	);
	return $html;

}


function treatmentHourFormTagHandler( $tag ) {
    if(empty($tag->name)) {
        return '';
    }
    $html = sprintf(
        '<div class="col-span-2 md:col-span-1 md:px-16 px-8">
            <div class="input-wrapper relative">
                <div class="icon-wrapper absolute left-[5px] top-1/2 -translate-y-1/2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.99967 15.0005C11.337 15.0007 14.2104 12.6448 14.8644 9.37222C15.5184 6.09959 13.7711 2.82037 10.69 1.53793C7.60892 0.255481 4.05095 1.32649 2.18976 4.09665C0.328562 6.86681 0.681801 10.5657 3.03367 12.9335C4.34765 14.2564 6.13511 15.0003 7.99967 15.0005Z" stroke="#AAAAAA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6.91064 6.16357V9.57557H10.1776" stroke="#AAAAAA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <input type="text" id="time-select" readonly name="%1$s" class="w-full pl-8 text-xl" style="border: 0; border-bottom: 1px solid #E2E4E5;" placeholder="Choose Time & Date">
                </div>
                <span class="wpcf7-not-valid-tip d-none invalid-time" aria-hidden="true">Please pick a time</span>
            <div class="time-wrapper grid grid-cols-2 gap-x-6 mt-4 overflow-y-auto mt-8" style="">

            </div>
        </div>',
        esc_attr( $tag->name )
    );
    return $html;
}

function treatmentPackageFormTagHandler( $tag ) {
    if(empty($tag->name)) {return '';}
    $packhtml = sprintf('<select name="%1$s[]" class="select2-custom-package">', esc_attr( $tag->name ));
    $packhtml .= '<option></option>';
    $args = array(
        'post_type' => 'treatment',
        'post_parent' => 0,
        'posts_per_page' => -1,
        'order' => 'ASC',
        'post_status' => 'publish'
    );

    if(isset($_GET['promo'])) {
        $__loop = new WP_Query(array(
            'post_type' => 'treatment',
            'name' => $_GET['promo'],
            'post_status' => 'publish'
        ));

        if( $__loop->have_posts() ) {
            while( $__loop->have_posts() ) {
                $__loop->the_post();

                $promo = array();
                $promo['id'] = get_field('treatment');
                $promo['price'] = get_field('price_to');
                $promoId = get_field('treatment');
                $promoPrice = get_field('price_to');
            }
        }
    }


    $loop = new WP_Query($args);
    if($loop->have_posts()) {
        while($loop->have_posts()) {
            $loop->the_post();
            $packhtml .= sprintf('<optgroup label="%1$s">', get_the_title());
            $parentId = get_the_id();

            $_args = array(
                'post_type' => 'treatment',
                'post_parent' => $parentId,
                'posts_per_page' => -1,
                'post_status' => 'publish'
            );
            $_loop = new WP_Query($_args);
            if($_loop->have_posts()){
                while($_loop->have_posts()) {
                    $_loop->the_post();

                    if(isset($promo)) {
                        $selected = $promo['id'] == get_the_id() ? 'selected data-promo="' . $promo['price'] . '"' : '';
                    } else {
                        $selected = $_POST['id'] == get_the_id() && $_POST['parentid'] == $parentId ? 'selected' : '';
                    }

                    $subtitle = '';
                    $duration = '';
                    $price = '';
                    if(get_field('duration', get_the_id())) {
                        $subtitle .= '(' . get_field('duration') . ' mins)';
                        $duration = 'data-duration="' . get_field('duration', get_the_id()) . '"';
                    }

                    if(get_field('price', get_the_id())) {
                        $subtitle .= 'IDR ' . get_field('price', get_the_id());
                        $price = 'data-price="' . get_field('price', get_the_id()) . '"';
                    }
                    
                    $packhtml .= sprintf('<option %3$s value="%1$s|%2$s" data-subtitle="%2$s" %4$s %5$s class="d-flex">%1$s</option>', get_the_title(), $subtitle, $selected, $price, $duration);
                }
            }

            wp_reset_postdata();
            // if(have_rows('package')) {
            //     while(have_rows('package')) {
            //         the_row();
            //         if($_POST['id'] == get_sub_field_object('title')['name'] && $_POST['parentid'] == $parentId) {
            //             $packhtml .= sprintf('<option selected value="%1$s|%2$s" data-subtitle="%2$s" class="d-flex">%1$s</option>', get_sub_field('title'), get_sub_field('subtitle'));
            //         } else {
            //             $packhtml .= sprintf('<option value="%1$s|%2$s" data-subtitle="%2$s" class="d-flex">%1$s</option>', get_sub_field('title'), get_sub_field('subtitle'));
            //         }
            //     }
            // }
            $packhtml .= sprintf('</optgroup>');
        }
    }

    $packhtml .= '</select>';

    return $packhtml;
}


add_filter('wpcf7_validate_treatmenthour*', 'customTreatmentHourValidationFilter', 20, 2);

function customTreatmentHourValidationFilter($result, $tag) {
    // var_dump($tag);
    if($tag->name == 'treathour') {
        $val = isset( $_POST['treathour'] ) ? trim( $_POST['treathour'] ) : '';
        
        if(!$val) {
            $result->invalidate($tag, 'Please pick a time');
            // var_dump($result);
        }

    }
    return $result;
}



function treatmentDiscountFormTagHandler( $tag ) {

    $val = '';
    if($_GET['promo']) {
        $val = $_GET['promo'];
    }
    $args = array(
        'post_type' => 'discount',
        'name' => $val,
        'post_status' => 'publish'
    );
    $loop = new WP_Query($args);
    if($loop->have_posts()) {
        while($loop->have_posts()) {
            $loop->the_post();

            if($treatId = get_field('treatment', get_the_id())) {

            }

        }
    }
    $html = sprintf(
        '<input type="hidden" name="promo-code" value="%1$s">',
        esc_attr($val)
    );
    return $html;
}



// $args = array(
//     'post_type' => 'tribe_events',
//     'posts_per_page' => '-1',
//     'orderby' => 'ID',
//     'order' => 'ASC',
//     'post_parent' => $postID,
// );

// $children = new WP_Query($args);
// $parent[] = get_post($postID);
// $family = array_merge($parent, $children->get_posts());