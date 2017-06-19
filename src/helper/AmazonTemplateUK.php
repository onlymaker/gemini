<?php

namespace helper;

class AmazonTemplateUK extends AmazonTemplate
{
    protected static $header = [
        [
            'TemplateType=Shoes',
            'Version=2015.1020',
            ['The top 3 rows are for Amazon.com use only. Do not modify or delete the top 3 rows.', 'C1', 'J1'],
            ['Offer - Offer Information - These attributes are required to make your item buyable for customers on the site.', 'K1', 'V1'],
            ['Dimensions - Product Dimensions - These attributes specify the size and weight of a product.', 'W1', 'AD1'],
            ['Discovery - Item discovery information - These attributes have an effect on how customers can find your product on the site using browse or search.', 'AE1', 'AP1'],
            ['Images - Image Information - See Image Instructions tab for details.', 'AQ1', 'AZ1'],
            ['Fulfillment - Use these columns to provide fulfilment-related information for orders fulfilled either by Amazon (FBA) or by the Seller.', 'BA1', 'BG1'],
            ['Variation - Variation information - Populate these attributes if your product is available in different variations (for example colour or wattage).', 'BH1', 'BK1'],
            ['Compliance - Compliance Information - Attributes used to comply with consumer laws in the country or region where the item is sold.', 'BL1', 'BM1'],
            ['Ungrouped - These attributes create rich product listings for your buyers.', 'BN1', 'CU1'],
        ],
        [
            'Seller SKU',
            'Product ID',
            'Product ID Type',
            'Product Name',
            'Brand',
            'Product Description',
            'Product Type',
            'Update Delete',
            'Manufacturer part number',
            'Model number',
            'Standard Price',
            'Currency',
            'Quantity',
            'Sale Price',
            'Sale From Date',
            'Sale End Date',
            'Item Package Quantity',
            'Can Be Gift Messaged',
            'Is Gift Wrap Available?',
            'Is Discontinued By Manufacturer',
            'Fulfillment Latency',
            'Merchant Shipping Group',
            'Website Shipping Weight Unit Of Measure',
            'Shipping Weight',
            'Item Length',
            'Item Height',
            'Item Width',
            'Item Dimensions Unit Of Measure',
            'Item Weight',
            'Unit Of Measure Of Item Weight',
            'Recommended Browse Node1',
            'Recommended Browse Node2',
            'Search Terms1',
            'Search Terms2',
            'Search Terms3',
            'Search Terms4',
            'Search Terms5',
            'Platinum Keywords1',
            'Platinum Keywords2',
            'Platinum Keywords3',
            'Platinum Keywords4',
            'Platinum Keywords5',
            'Main Image URL',
            'Other Image URL1',
            'Other Image URL2',
            'Other Image URL3',
            'Other Image URL4',
            'Other Image URL5',
            'Other Image URL6',
            'Other Image URL7',
            'Other Image URL8',
            'Swatch Image Url',
            'Package Height',
            'Package Width',
            'Package Length',
            'Package Dimensions Unit Of Measure',
            'Package Weight',
            'Package Weight Unit Of Measure',
            'Fulfillment Centre ID',
            'Parentage',
            'Parent SKU',
            'Relationship Type',
            'Variation Theme',
            'Country Of Origin',
            'EU Toys Safety Directive Non-Age-specific warning',
            'Department',
            'Model Name',
            'Strap Type',
            'Model Year',
            'Style Name',
            'Colour',
            'Colour Map',
            'size',
            'Size Map',
            'Material Composition',
            'Inner Material Type',
            'Outer Material Type',
            'Insole Type',
            'Leather Type',
            'Sole Material',
            'Collection',
            'Season',
            'Heel Type',
            'Heel Height',
            'Shaft Height',
            'Shaft Diameter',
            'Platform Height',
            'Shoe Width',
            'Closure Type',
            'Arch Type',
            'Water Resistance Level',
            'Cleat Description',
            'Pronation Correction',
            'Sport Type',
            'Surface Recommendation',
            'Shoe Safety Code ISO 20345',
            'Lining Description',
            'Heel Height Unit Of Measure',
            'Shoulder Strap Drop',
        ],
        [
            'item_sku',
            'external_product_id',
            'external_product_id_type',
            'item_name',
            'brand_name',
            'product_description',
            'feed_product_type',
            'update_delete',
            'part_number',
            'model',
            'standard_price',
            'currency',
            'quantity',
            'sale_price',
            'sale_from_date',
            'sale_end_date',
            'item_package_quantity',
            'offering_can_be_gift_messaged',
            'offering_can_be_giftwrapped',
            'is_discontinued_by_manufacturer',
            'fulfillment_latency',
            'merchant_shipping_group_name',
            'website_shipping_weight_unit_of_measure',
            'website_shipping_weight',
            'item_length',
            'item_height',
            'item_width',
            'item_dimensions_unit_of_measure',
            'item_weight',
            'item_weight_unit_of_measure',
            'recommended_browse_nodes1',
            'recommended_browse_nodes2',
            'generic_keywords1',
            'generic_keywords2',
            'generic_keywords3',
            'generic_keywords4',
            'generic_keywords5',
            'platinum_keywords1',
            'platinum_keywords2',
            'platinum_keywords3',
            'platinum_keywords4',
            'platinum_keywords5',
            'main_image_url',
            'other_image_url1',
            'other_image_url2',
            'other_image_url3',
            'other_image_url4',
            'other_image_url5',
            'other_image_url6',
            'other_image_url7',
            'other_image_url8',
            'swatch_image_url',
            'package_height',
            'package_width',
            'package_length',
            'package_dimensions_unit_of_measure',
            'package_weight',
            'package_weight_unit_of_measure',
            'fulfillment_center_id',
            'parent_child',
            'parent_sku',
            'relationship_type',
            'variation_theme',
            'country_of_origin',
            'eu_toys_safety_directive_warning',
            'department_name',
            'model_name',
            'strap_type',
            'model_year',
            'style_name',
            'color_name',
            'color_map',
            'size_name',
            'size_map',
            'material_composition',
            'inner_material_type',
            'outer_material_type',
            'insole_type',
            'leather_type',
            'sole_material',
            'collection_name',
            'seasons',
            'heel_type',
            'heel_height',
            'shaft_height',
            'shaft_diameter',
            'platform_height',
            'shoe_width',
            'closure_type',
            'arch_type',
            'water_resistance_level',
            'cleat_description',
            'pronation_correction',
            'sport_type',
            'surface_recommendation',
            'shoe_safety_code_iso_20345',
            'lining_description',
            'heel_height_unit_of_measure',
            'shoulder_strap_drop',
        ]
    ];

    protected static function parent($data)
    {
        $fields = array_flip(self::$header[2]);
        $row = [$data['store'] . '-' . $data['model']];
        $row[$fields['external_product_id']] = '';
        $row[$fields['external_product_id_type']] = '';
        $row[$fields['item_name']] = $data['name'];
        $row[$fields['brand_name']] = $data['brand'];
        $row[$fields['product_description']] = self::getDescription();
        $row[$fields['feed_product_type']] = 'shoes';
        $row[$fields['update_delete']] = '';
        $row[$fields['part_number']] = '';
        $row[$fields['model']] = $row[$fields['item_sku']];
        $row[$fields['standard_price']] = $data['price'];
        $row[$fields['currency']] = $data['currency'];
        $row[$fields['quantity']] = 100;
        $row[$fields['sale_price']] = '';
        $row[$fields['sale_from_date']] = '';
        $row[$fields['sale_end_date']] = '';
        $row[$fields['item_package_quantity']] = '';
        $row[$fields['offering_can_be_gift_messaged']] = '';
        $row[$fields['offering_can_be_giftwrapped']] = '';
        $row[$fields['is_discontinued_by_manufacturer']] = '';
        $row[$fields['fulfillment_latency']] = 11;
        $row[$fields['merchant_shipping_group_name']] = $data['delivery'] == 'null' ? '' : $data['delivery'];
        $row[$fields['website_shipping_weight_unit_of_measure']] = 'KG';
        $row[$fields['website_shipping_weight']] = 1;
        $row[$fields['item_length']] = '';
        $row[$fields['item_height']] = '';
        $row[$fields['item_width']] = '';
        $row[$fields['item_dimensions_unit_of_measure']] = '';
        $row[$fields['item_weight']] = 1;
        $row[$fields['item_weight_unit_of_measure']] = 'KG';
        $row[$fields['recommended_browse_nodes1']] = '';//TODO
        $row[$fields['recommended_browse_nodes2']] = $row[$fields['recommended_browse_nodes1']];
        $row[$fields['generic_keywords1']] = $data['bulletPoint'][0];
        $row[$fields['generic_keywords2']] = $data['bulletPoint'][1];
        $row[$fields['generic_keywords3']] = $data['bulletPoint'][2];
        $row[$fields['generic_keywords4']] = $data['bulletPoint'][3];
        $row[$fields['generic_keywords5']] = $data['bulletPoint'][4];
        $row[$fields['platinum_keywords1']] = '';
        $row[$fields['platinum_keywords2']] = '';
        $row[$fields['platinum_keywords3']] = '';
        $row[$fields['platinum_keywords4']] = '';
        $row[$fields['platinum_keywords5']] = '';

        $images = self::getImages($data['store'], $data['model']);
        //父产品只要一张图
        if ($images) {
            $row[$fields['main_image_url']] = array_shift($images);
        } else {
            $row[$fields['main_image_url']] = '';
        }
        $row[$fields['other_image_url1']] = '';
        $row[$fields['other_image_url2']] = '';
        $row[$fields['other_image_url3']] = '';
        $row[$fields['other_image_url4']] = '';
        $row[$fields['other_image_url5']] = '';
        $row[$fields['other_image_url6']] = '';
        $row[$fields['other_image_url7']] = '';
        $row[$fields['other_image_url8']] = '';

        $row[$fields['swatch_image_url']] = '';

        $row[$fields['package_height']] = '';
        $row[$fields['package_width']] = '';
        $row[$fields['package_length']] = '';
        $row[$fields['package_dimensions_unit_of_measure']] = '';
        $row[$fields['package_weight']] = '';
        $row[$fields['package_weight_unit_of_measure']] = '';
        $row[$fields['fulfillment_center_id']] = '';
        $row[$fields['parent_child']] = 'parent';
        $row[$fields['parent_sku']] = '';
        $row[$fields['relationship_type']] = '';
        $row[$fields['variation_theme']] = '';
        $row[$fields['country_of_origin']] = '';
        $row[$fields['eu_toys_safety_directive_warning']] = '';
        $row[$fields['department_name']] = 'womens';
        $row[$fields['model_name']] = $row[$fields['item_sku']];
        $row[$fields['strap_type']] = $data['strap'];
        $row[$fields['model_year']] = 2017;
        $row[$fields['style_name']] = $data['keyword'][0];
        $row[$fields['color_name']] = '';
        $row[$fields['color_map']] = '';
        $row[$fields['size_name']] = '';
        $row[$fields['size_map']] = '';
        $row[$fields['material_composition']] = '';
        $row[$fields['inner_material_type']] = '';
        $row[$fields['outer_material_type']] = '';
        $row[$fields['insole_type']] = '';
        $row[$fields['leather_type']] = '';
        $row[$fields['sole_material']] = '';
        $row[$fields['collection_name']] = '';
        $row[$fields['seasons']] = '';
        $row[$fields['heel_type']] = '';
        $row[$fields['heel_height']] = '';
        $row[$fields['shaft_height']] = '';
        $row[$fields['shaft_diameter']] = '';
        $row[$fields['platform_height']] = '';
        $row[$fields['shoe_width']] = '';
        $row[$fields['closure_type']] = '';
        $row[$fields['arch_type']] = '';
        $row[$fields['water_resistance_level']] = '';
        $row[$fields['cleat_description']] = '';
        $row[$fields['pronation_correction']] = '';
        $row[$fields['sport_type']] = '';
        $row[$fields['surface_recommendation']] = '';
        $row[$fields['shoe_safety_code_iso_20345']] = '';
        $row[$fields['lining_description']] = '';
        $row[$fields['heel_height_unit_of_measure']] = '';
        $row[$fields['shoulder_strap_drop']] = '';
        return $row;
    }

    protected static function children($sku, $data)
    {
        $rows = [];
        $fields = array_flip(self::$header[2]);
        $marketUnit = Store::get($data['store'])['market_unit'];
        $sizeArray = self::getSize($data['size'], $data['store']);
        foreach ($sizeArray as $size) {
            $row = [$data['store'] . '-' . $sku['sku'] . '-' . $marketUnit . $size];
            $row[$fields['external_product_id']] = $data['upc'] == 1 ? self::getUPC() : '';
            $row[$fields['external_product_id_type']] = '';
            $row[$fields['item_name']] = $data['name'] . '-' . $sku['colorName'] . '-' . $size;
            $row[$fields['brand_name']] = $data['brand'];
            $row[$fields['product_description']] = self::getDescription();
            $row[$fields['feed_product_type']] = 'shoes';
            $row[$fields['update_delete']] = '';
            $row[$fields['part_number']] = '';
            $row[$fields['model']] = $row[$fields['item_sku']];
            $row[$fields['standard_price']] = $data['price'];
            $row[$fields['currency']] = $data['currency'];
            $row[$fields['quantity']] = 100;
            $row[$fields['sale_price']] = '';
            $row[$fields['sale_from_date']] = '';
            $row[$fields['sale_end_date']] = '';
            $row[$fields['item_package_quantity']] = '';
            $row[$fields['offering_can_be_gift_messaged']] = '';
            $row[$fields['offering_can_be_giftwrapped']] = '';
            $row[$fields['is_discontinued_by_manufacturer']] = '';
            $row[$fields['fulfillment_latency']] = 11;
            $row[$fields['merchant_shipping_group_name']] = $data['delivery'] == 'null' ? '' : $data['delivery'];
            $row[$fields['website_shipping_weight_unit_of_measure']] = 'KG';
            $row[$fields['website_shipping_weight']] = 1;
            $row[$fields['item_length']] = '';
            $row[$fields['item_height']] = '';
            $row[$fields['item_width']] = '';
            $row[$fields['item_dimensions_unit_of_measure']] = '';
            $row[$fields['item_weight']] = 1;
            $row[$fields['item_weight_unit_of_measure']] = 'KG';
            $row[$fields['recommended_browse_nodes1']] = '';//TODO
            $row[$fields['recommended_browse_nodes2']] = $row[$fields['recommended_browse_nodes1']];
            $row[$fields['generic_keywords1']] = $data['bulletPoint'][0];
            $row[$fields['generic_keywords2']] = $data['bulletPoint'][1];
            $row[$fields['generic_keywords3']] = $data['bulletPoint'][2];
            $row[$fields['generic_keywords4']] = $data['bulletPoint'][3];
            $row[$fields['generic_keywords5']] = $data['bulletPoint'][4];
            $row[$fields['platinum_keywords1']] = '';
            $row[$fields['platinum_keywords2']] = '';
            $row[$fields['platinum_keywords3']] = '';
            $row[$fields['platinum_keywords4']] = '';
            $row[$fields['platinum_keywords5']] = '';

            $images = self::getImages($data['store'], $sku['sku']);
            if ($images) {
                $row[$fields['main_image_url']] = array_shift($images);
                $total = 8;
                $length = min(count($images), $total);
                for($i = 1; $i <= $total; $i++) {
                    $name = 'other_image_url' . $i;
                    if ($i <= $length) {
                        $row[$fields[$name]] = $images[$i - 1];
                    } else {
                        $row[$fields[$name]] = '';
                    }
                }
                if ($length == $total) {
                    $row[$fields['swatch_image_url']] = self::getSwatchImageUrl($data['store']);
                } else {
                    $row[$fields['other_image_url' . ++ $length]] = self::getSwatchImageUrl($data['store']);
                    $row[$fields['swatch_image_url']] = '';
                }
            } else {
                $row[$fields['main_image_url']] = self::getSwatchImageUrl($data['store']);
                $row[$fields['other_image_url1']] = '';
                $row[$fields['other_image_url2']] = '';
                $row[$fields['other_image_url3']] = '';
                $row[$fields['other_image_url4']] = '';
                $row[$fields['other_image_url5']] = '';
                $row[$fields['other_image_url6']] = '';
                $row[$fields['other_image_url7']] = '';
                $row[$fields['other_image_url8']] = '';
                $row[$fields['swatch_image_url']] = '';
            }

            $row[$fields['package_height']] = '';
            $row[$fields['package_width']] = '';
            $row[$fields['package_length']] = '';
            $row[$fields['package_dimensions_unit_of_measure']] = '';
            $row[$fields['package_weight']] = '';
            $row[$fields['package_weight_unit_of_measure']] = '';
            $row[$fields['fulfillment_center_id']] = '';
            $row[$fields['parent_child']] = 'child';
            $row[$fields['parent_sku']] = $data['store'] . '-' . $data['model'];
            $row[$fields['relationship_type']] = '';
            $row[$fields['variation_theme']] = '';
            $row[$fields['country_of_origin']] = '';
            $row[$fields['eu_toys_safety_directive_warning']] = '';
            $row[$fields['department_name']] = 'womens';
            $row[$fields['model_name']] = $row[$fields['item_sku']];
            $row[$fields['strap_type']] = $data['strap'];
            $row[$fields['model_year']] = 2017;
            $row[$fields['style_name']] = $data['keyword'][0];
            $row[$fields['color_name']] = $sku['colorName'];
            $row[$fields['color_map']] = $sku['colorMap'];
            $row[$fields['size_name']] = $marketUnit . $size;
            $row[$fields['size_map']] = $marketUnit . $size;
            $row[$fields['material_composition']] = '';
            $row[$fields['inner_material_type']] = '';
            $row[$fields['outer_material_type']] = $data['material'];
            $row[$fields['insole_type']] = '';
            $row[$fields['leather_type']] = '';
            $row[$fields['sole_material']] = '';
            $row[$fields['collection_name']] = '';
            $row[$fields['seasons']] = '';
            $row[$fields['heel_type']] = $data['heel'];
            $row[$fields['heel_height']] = $data['heelHeight'];
            $row[$fields['shaft_height']] = $data['shaftHeight'];
            $row[$fields['shaft_diameter']] = '';
            $row[$fields['platform_height']] = $data['platformHeight'];
            $row[$fields['shoe_width']] = 'Normal';
            $row[$fields['closure_type']] = $data['closure'];
            $row[$fields['arch_type']] = '';
            $row[$fields['water_resistance_level']] = '';
            $row[$fields['cleat_description']] = '';
            $row[$fields['pronation_correction']] = '';
            $row[$fields['sport_type']] = '';
            $row[$fields['surface_recommendation']] = '';
            $row[$fields['shoe_safety_code_iso_20345']] = '';
            $row[$fields['lining_description']] = '';
            $row[$fields['heel_height_unit_of_measure']] = 'CM';
            $row[$fields['shoulder_strap_drop']] = '';

            $rows[] = $row;
        }
        return $rows;
    }
}
