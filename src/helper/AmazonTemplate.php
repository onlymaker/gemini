<?php

namespace helper;

/*
【说明】
Item_sku:
父SKU：站点-SKU 的方式构成
子SKU：站点-SKU-尺码 的方式构成；尺码分现货鞋与生产鞋；尺码根据站点不同分 US UK EU
Item name：
父标题=标题
子标题=父标题+颜色+尺码
Image：
1.链接中的SKU，针对不同的子产品，SKU有不同
2.希望支持自动从产品数据库调取图片做图片服务起上传，链接生成格式固定，图片服务器：https://www.qiniu.com/，有接口
 */
use data\Database;
use DB\SQL\Mapper;

class AmazonTemplate
{
    private static $type = 'Shoes';
    private static $version = '2015.1008';
    private static $head = [
        'item_sku',//first line: model; others generated by sku,见说明
        'item_name',//name,见说明
        'external_product_id',//EAN码，如果勾选需要EAN，EAN和UPC是同一个意思
        'external_product_id_type',//EAN
        'brand_name',//brand
        'product_description',//固定内容，可暂时忽略
        'item_type',//itemType，不同的站点会有不同内容和填入方式
        'model',//first line empty; others generated by sku
        'update_delete',// 空
        'standard_price',//price
        'list_price',//空
        'currency',//currency
        'product_tax_code',//空
        'fulfillment_latency',//11
        'product_site_launch_date',//空
        'merchant_release_date',//空
        'restock_date',//空
        'quantity',//100
        'sale_price',//空
        'sale_from_date',//空
        'sale_end_date',//空
        'max_aggregate_ship_quantity',//空
        'item_package_quantity',//空
        'offering_can_be_gift_messaged',//空
        'offering_can_be_giftwrapped',//空
        'is_discontinued_by_manufacturer',//空
        'missing_keyset_reason',//空
        'delivery_schedule_group_id',//空
        'merchant_shipping_group_name',//delivery，空或者free shipping
        'website_shipping_weight',//1
        'website_shipping_weight_unit_of_measure',//KG
        'item_weight_unit_of_measure',//KG
        'item_weight',//1
        'item_length_unit_of_measure',//空
        'item_length',//空
        'item_width',//空
        'item_height',//空
        'bullet_point1',//bulletPoint1
        'bullet_point2',//bulletPoint2
        'bullet_point3',//bulletPoint3
        'bullet_point4',//bulletPoint4
        'bullet_point5',//bulletPoint5
        'generic_keywords1',//系统通过关键词库生成
        'generic_keywords2',//系统通过关键词库生成
        'generic_keywords3',//系统通过关键词库生成
        'generic_keywords4',//系统通过关键词库生成
        'generic_keywords5',//系统通过关键词库生成
        'style_keywords1',//keyword1
        'style_keywords2',//keyword2
        'style_keywords3',//keyword3
        'platinum_keywords1',//空
        'platinum_keywords2',//空
        'platinum_keywords3',//空
        'platinum_keywords4',//空
        'platinum_keywords5',//空
        'main_image_url',//http://oi9kpzs50.bkt.clouddn.com/站点/SKU/1.jpg，见说明
        'other_image_url1',//http://oi9kpzs50.bkt.clouddn.com/站点/SKU/2.jpg，见说明
        'other_image_url2',//http://oi9kpzs50.bkt.clouddn.com/站点/SKU/3.jpg，见说明
        'other_image_url3',//http://oi9kpzs50.bkt.clouddn.com/站点/SKU/4.jpg，见说明
        'other_image_url4',//http://oi9kpzs50.bkt.clouddn.com/站点/SKU/5.jpg，见说明
        'other_image_url5',//http://oi9kpzs50.bkt.clouddn.com/站点/SKU/6.jpg，见说明
        'other_image_url6',//同上，随着图片数量相应填入
        'other_image_url7',//同上，随着图片数量相应填入
        'other_image_url8',//同上，随着图片数量相应填入
        'swatch_image_url',//尺码图，固定链接，分站点
        'fulfillment_center_id',//空
        'package_height',//空
        'package_width',//空
        'package_length',//空
        'package_length_unit_of_measure',//空
        'package_weight',//空
        'package_weight_unit_of_measure',//空
        'parent_child',//parent or child，第一行是parent
        'parent_sku',//子SKU
        'relationship_type',//variation
        'variation_theme',//Size/Color
        'prop_65',//空
        'cpsia_cautionary_description',//空
        'cpsia_cautionary_statement1',//空
        'cpsia_cautionary_statement2',//空
        'cpsia_cautionary_statement3',//空
        'cpsia_cautionary_statement4',//空
        'style_name',//keyword1
        'lens_color',//空
        'lens_color_map',//空
        'magnification_strength',//空
        'frame_material_type',//空
        'lens_material_type',//空
        'item_shape',//空
        'polarization_type',//空
        'lens_width',//空
        'bridge_width',//空
        'arm_length',//空
        'lens_height',//空
        'eyewear_unit_of_measure',//空
        'closure_type',//closure
        'department_name',//women
        'color_name',//colorName
        'color_map',//colorMap
        'import_designation',//空
        'country_as_labeled',//空
        'fur_description',//空
        'lifestyle',//occasion
        'special_features1',//feature1
        'special_features2',//feature2
        'special_features3',//feature3
        'subject_character1',//空
        'subject_character2',//空
        'subject_character3',//空
        'subject_character4',//空
        'subject_character5',//空
        'strap_type',//strap
        'lining_description',//空
        'shoulder_strap_drop',//空
        'shoulder_strap_drop_unit_of_measure',//空
        'size_name',//现货或者生产尺码
        'is_stain_resistant',//空
        'material_type1',//"material"
        'material_type2',//空
        'material_type3',//空
        'pattern_type',//pattern
        'model_year',//2017
        'shoe_dimension_unit_of_measure',//空
        'sole_material',//空
        'heel_type',//heel
        'height_map',//heightMap
        'toe_style',//toe
        'arch_type',//neutral，固定
        'cleat_description',//空
        'cleat_material_type',//空
        'team_name',//空
        'shaft_height',//shaftHeight
        'minimum_circumference',//minimumCircumference
        'heel_height',//heelHeight
        'platform_height',//platformHeight
        'water_resistance_level'//空
    ];

    private static function getData($table, $id)
    {
        $mapper = new Mapper(Database::mysql(), $table);
        $mapper->load(['id = ?', $id]);
        return $mapper->dry() ? 'null' : $mapper['data'];
    }

    /**
     * @param $store       : store id
     * @return mixed|string: store name
     */
    private static function getSite($store)
    {
        $store = self::getData('store', $store);
        switch ($store) {
            case 'OMDE':
            case 'KHDE':
                return 'EU';
            case 'OMUK':
            case 'KHUK':
                return 'UK';
            case 'AHUS':
            case 'CLUS':
            case 'OMCA':
                return 'US';
            default:
                return $store;
        }
    }

    /**
     * @param $type : 尺码类型（manufacture/stock）
     * @param $store: store id
     * @return array
     */
    private static function getSize($type, $store)
    {
        $store = self::getData('store', $store);
        switch ($type) {
            case 'manufacture':
                if ($store == 'EU') {
                    return [35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46];
                } else if ($store == 'UK') {
                    return [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
                } else if ($store == 'US') {
                    return [5, 6, 7, 8, 9, 9.5, 10, 11, 12, 13, 14, 15];
                } else {
                    return [];
                }
            case 'stock':
                if ($store == 'EU') {
                    return [35.5, 36, 36.5, 37, 37.5, 38, 38.5, 39, 39.5, 40, 40.5, 41, 41.5, 42, 43, 44, 45];
                } else if ($store == 'UK') {
                    return [3, 3.5, 4, 4.5, 5, 5.5, 6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5, 10, 10.5, 11];
                } else if ($store == 'US') {
                    return [5, 5.5, 6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5, 10, 10.5, 11, 11.5, 12, 13, 14];
                } else {
                    return [];
                }
            default:
                return [];
        }
    }

    private static function getUPC($upc)
    {
        //TODO
    }

    private static function parent($data)
    {
        $fields = array_flip(self::$head);
        $row = [self::getSite($data['store']) . '-' . $data['model']];
        $row[$fields['item_name']] = $data['name'];
        $row[$fields['external_product_id']] = $data['upc'] == 1 ? self::getUPC($data['upc']) : '';
        $row[$fields['external_product_id_type']] = 'EAN';
        $row[$fields['brand_name']] = self::getData('brand', $data['brand']);
        $row[$fields['product_description']] = iconv('utf-8', 'gbk', '固定内容，可暂时忽略');
        $row[$fields['item_type']] = self::getData('item_type', $data['itemType']);
        $row[$fields['model']] = $row[$fields['item_sku']];
        $row[$fields['update_delete']] = '';
        $row[$fields['standard_price']] = $data['price'];
        $row[$fields['list_price']] = '';
        $row[$fields['currency']] = $data['currency'];
        $row[$fields['product_tax_code']] = '';
        $row[$fields['fulfillment_latency']] = 11;
        $row[$fields['product_site_launch_date']] = '';
        $row[$fields['merchant_release_date']] = '';
        $row[$fields['restock_date']] = '';
        $row[$fields['quantity']] = 100;
        $row[$fields['sale_price']] = '';
        $row[$fields['sale_from_date']] = '';
        $row[$fields['sale_end_date']] = '';
        $row[$fields['max_aggregate_ship_quantity']] = '';
        $row[$fields['item_package_quantity']] = '';
        $row[$fields['offering_can_be_gift_messaged']] = '';
        $row[$fields['offering_can_be_giftwrapped']] = '';
        $row[$fields['is_discontinued_by_manufacturer']] = '';
        $row[$fields['missing_keyset_reason']] = '';
        $row[$fields['delivery_schedule_group_id']] = '';
        $row[$fields['merchant_shipping_group_name']] = $data['delivery'] == 'null' ? '' : $data['delivery'];
        $row[$fields['website_shipping_weight']] = 1;
        $row[$fields['website_shipping_weight_unit_of_measure']] = 'KG';
        $row[$fields['item_weight_unit_of_measure']] = 'KG';
        $row[$fields['item_weight']] = 1;
        $row[$fields['item_length_unit_of_measure']] = '';
        $row[$fields['item_length']] = '';
        $row[$fields['item_width']] = '';
        $row[$fields['item_height']] = '';
        $row[$fields['bullet_point1']] = $data['bluePoint'][0];
        $row[$fields['bullet_point2']] = $data['bluePoint'][1];
        $row[$fields['bullet_point3']] = $data['bluePoint'][2];
        $row[$fields['bullet_point4']] = $data['bluePoint'][3];
        $row[$fields['bullet_point5']] = $data['bluePoint'][4];
        $row[$fields['generic_keywords1']] = 'TODO';
        $row[$fields['generic_keywords2']] = 'TODO';
        $row[$fields['generic_keywords3']] = 'TODO';
        $row[$fields['generic_keywords4']] = 'TODO';
        $row[$fields['generic_keywords5']] = 'TODO';
        $row[$fields['style_keywords1']] = self::getData('keyword', $data['keyword'][0]);
        $row[$fields['style_keywords2']] = self::getData('keyword', $data['keyword'][1]);
        $row[$fields['style_keywords3']] = self::getData('keyword', $data['keyword'][2]);
        $row[$fields['platinum_keywords1']] = '';
        $row[$fields['platinum_keywords2']] = '';
        $row[$fields['platinum_keywords3']] = '';
        $row[$fields['platinum_keywords4']] = '';
        $row[$fields['platinum_keywords5']] = '';
        $row[$fields['main_image_url']] = '';  //http://oi9kpzs50.bkt.clouddn.com/站点/SKU/1.jpg，见说明
        $row[$fields['other_image_url1']] = '';//http://oi9kpzs50.bkt.clouddn.com/站点/SKU/2.jpg，见说明
        $row[$fields['other_image_url2']] = '';//http://oi9kpzs50.bkt.clouddn.com/站点/SKU/3.jpg，见说明
        $row[$fields['other_image_url3']] = '';//http://oi9kpzs50.bkt.clouddn.com/站点/SKU/4.jpg，见说明
        $row[$fields['other_image_url4']] = '';//http://oi9kpzs50.bkt.clouddn.com/站点/SKU/5.jpg，见说明
        $row[$fields['other_image_url5']] = '';//http://oi9kpzs50.bkt.clouddn.com/站点/SKU/6.jpg，见说明
        $row[$fields['other_image_url6']] = '';//同上，随着图片数量相应填入
        $row[$fields['other_image_url7']] = '';//同上，随着图片数量相应填入
        $row[$fields['other_image_url8']] = '';//同上，随着图片数量相应填入
        $row[$fields['swatch_image_url']] = '';//尺码图，固定链接，分站点
        $row[$fields['fulfillment_center_id']] = '';
        $row[$fields['package_height']] = '';
        $row[$fields['package_width']] = '';
        $row[$fields['package_length']] = '';
        $row[$fields['package_length_unit_of_measure']] = '';
        $row[$fields['package_weight']] = '';
        $row[$fields['package_weight_unit_of_measure']] = '';
        $row[$fields['parent_child']] = 'parent';
        $row[$fields['parent_sku']] = '';
        $row[$fields['relationship_type']] = 'variation';
        $row[$fields['variation_theme']] = 'Size/Color';
        $row[$fields['prop_65']] = '';
        $row[$fields['cpsia_cautionary_description']] = '';
        $row[$fields['cpsia_cautionary_statement1']] = '';
        $row[$fields['cpsia_cautionary_statement2']] = '';
        $row[$fields['cpsia_cautionary_statement3']] = '';
        $row[$fields['cpsia_cautionary_statement4']] = '';
        $row[$fields['style_name']] = self::getData('keyword', $data['keyword'][0]);
        $row[$fields['lens_color']] = '';
        $row[$fields['lens_color_map']] = '';
        $row[$fields['magnification_strength']] = '';
        $row[$fields['frame_material_type']] = '';
        $row[$fields['lens_material_type']] = '';
        $row[$fields['item_shape']] = '';
        $row[$fields['polarization_type']] = '';
        $row[$fields['lens_width']] = '';
        $row[$fields['bridge_width']] = '';
        $row[$fields['arm_length']] = '';
        $row[$fields['lens_height']] = '';
        $row[$fields['eyewear_unit_of_measure']] = '';
        $row[$fields['closure_type']] = self::getData('closure', $data['closure']);
        $row[$fields['department_name']] = 'women';
        $row[$fields['color_name']] = '';
        $row[$fields['color_map']] = '';
        $row[$fields['import_designation']] = '';
        $row[$fields['country_as_labeled']] = '';
        $row[$fields['fur_description']] = '';
        $row[$fields['lifestyle']] = self::getData('lifestyle', $data['lifestyle']);
        $row[$fields['special_features1']] = self::getData('feature', $data['feature'][0]);
        $row[$fields['special_features2']] = self::getData('feature', $data['feature'][1]);
        $row[$fields['special_features3']] = self::getData('feature', $data['feature'][2]);
        $row[$fields['subject_character1']] = '';
        $row[$fields['subject_character2']] = '';
        $row[$fields['subject_character3']] = '';
        $row[$fields['subject_character4']] = '';
        $row[$fields['subject_character5']] = '';
        $row[$fields['strap_type']] = self::getData('strap', $data['strap']);
        $row[$fields['lining_description']] = '';
        $row[$fields['shoulder_strap_drop']] = '';
        $row[$fields['shoulder_strap_drop_unit_of_measure']] = '';
        $row[$fields['size_name']] = '';
        $row[$fields['is_stain_resistant']] = '';
        $row[$fields['material_type1']] = self::getData('material', $data['material']);
        $row[$fields['material_type2']] = '';
        $row[$fields['material_type3']] = '';
        $row[$fields['pattern_type']] = self::getData('pattern', $data['pattern']);
        $row[$fields['model_year']] = date('Y');
        $row[$fields['shoe_dimension_unit_of_measure']] = '';
        $row[$fields['sole_material']] = '';
        $row[$fields['heel_type']] = self::getData('heel', $data['heel']);
        $row[$fields['height_map']] = $data['heightMap'];
        $row[$fields['toe_style']] = self::getData('toe', $data['toe']);
        $row[$fields['arch_type']] = 'neutral';
        $row[$fields['cleat_description']] = '';
        $row[$fields['cleat_material_type']] = '';
        $row[$fields['team_name']] = '';
        $row[$fields['shaft_height']] = $data['shaftHeight'];
        $row[$fields['minimum_circumference']] = $data['minimumCircumference'];
        $row[$fields['heel_height']] = $data['heelHeight'];
        $row[$fields['platform_height']] = $data['platformHeight'];
        $row[$fields['water_resistance_level']] = '';
        return $row;
    }

    private static function children($sku, $data)
    {
        $rows = [];
        $fields = array_flip(self::$head);
        $sizeArray = self::getSize($data['size'], $data['store']);
        foreach ($sizeArray as $size) {
            $row = [self::getSite($data['store']) . '-' . $data['model']] . '-' . $size;
            $row[$fields['item_name']] = $data['name'] . '-' . $sku['colorName'] . '-' . $size;
            $row[$fields['external_product_id']] = $data['upc'] == 1 ? self::getUPC($data['upc']) : '';
            $row[$fields['external_product_id_type']] = 'EAN';
            $row[$fields['brand_name']] = self::getData('brand', $data['brand']);
            $row[$fields['product_description']] = iconv('utf-8', 'gbk', '固定内容，可暂时忽略');
            $row[$fields['item_type']] = self::getData('item_type', $data['itemType']);
            $row[$fields['model']] = $row[$fields['item_sku']];
            $row[$fields['update_delete']] = '';
            $row[$fields['standard_price']] = $data['price'];
            $row[$fields['list_price']] = '';
            $row[$fields['currency']] = $data['currency'];
            $row[$fields['product_tax_code']] = '';
            $row[$fields['fulfillment_latency']] = 11;
            $row[$fields['product_site_launch_date']] = '';
            $row[$fields['merchant_release_date']] = '';
            $row[$fields['restock_date']] = '';
            $row[$fields['quantity']] = 100;
            $row[$fields['sale_price']] = '';
            $row[$fields['sale_from_date']] = '';
            $row[$fields['sale_end_date']] = '';
            $row[$fields['max_aggregate_ship_quantity']] = '';
            $row[$fields['item_package_quantity']] = '';
            $row[$fields['offering_can_be_gift_messaged']] = '';
            $row[$fields['offering_can_be_giftwrapped']] = '';
            $row[$fields['is_discontinued_by_manufacturer']] = '';
            $row[$fields['missing_keyset_reason']] = '';
            $row[$fields['delivery_schedule_group_id']] = '';
            $row[$fields['merchant_shipping_group_name']] = $data['delivery'] == 'null' ? '' : $data['delivery'];
            $row[$fields['website_shipping_weight']] = 1;
            $row[$fields['website_shipping_weight_unit_of_measure']] = 'KG';
            $row[$fields['item_weight_unit_of_measure']] = 'KG';
            $row[$fields['item_weight']] = 1;
            $row[$fields['item_length_unit_of_measure']] = '';
            $row[$fields['item_length']] = '';
            $row[$fields['item_width']] = '';
            $row[$fields['item_height']] = '';
            $row[$fields['bullet_point1']] = $data['bluePoint'][0];
            $row[$fields['bullet_point2']] = $data['bluePoint'][1];
            $row[$fields['bullet_point3']] = $data['bluePoint'][2];
            $row[$fields['bullet_point4']] = $data['bluePoint'][3];
            $row[$fields['bullet_point5']] = $data['bluePoint'][4];
            $row[$fields['generic_keywords1']] = 'TODO';
            $row[$fields['generic_keywords2']] = 'TODO';
            $row[$fields['generic_keywords3']] = 'TODO';
            $row[$fields['generic_keywords4']] = 'TODO';
            $row[$fields['generic_keywords5']] = 'TODO';
            $row[$fields['style_keywords1']] = self::getData('keyword', $data['keyword'][0]);
            $row[$fields['style_keywords2']] = self::getData('keyword', $data['keyword'][1]);
            $row[$fields['style_keywords3']] = self::getData('keyword', $data['keyword'][2]);
            $row[$fields['platinum_keywords1']] = '';
            $row[$fields['platinum_keywords2']] = '';
            $row[$fields['platinum_keywords3']] = '';
            $row[$fields['platinum_keywords4']] = '';
            $row[$fields['platinum_keywords5']] = '';
            $row[$fields['main_image_url']] = '';  //http://oi9kpzs50.bkt.clouddn.com/站点/SKU/1.jpg，见说明
            $row[$fields['other_image_url1']] = '';//http://oi9kpzs50.bkt.clouddn.com/站点/SKU/2.jpg，见说明
            $row[$fields['other_image_url2']] = '';//http://oi9kpzs50.bkt.clouddn.com/站点/SKU/3.jpg，见说明
            $row[$fields['other_image_url3']] = '';//http://oi9kpzs50.bkt.clouddn.com/站点/SKU/4.jpg，见说明
            $row[$fields['other_image_url4']] = '';//http://oi9kpzs50.bkt.clouddn.com/站点/SKU/5.jpg，见说明
            $row[$fields['other_image_url5']] = '';//http://oi9kpzs50.bkt.clouddn.com/站点/SKU/6.jpg，见说明
            $row[$fields['other_image_url6']] = '';//同上，随着图片数量相应填入
            $row[$fields['other_image_url7']] = '';//同上，随着图片数量相应填入
            $row[$fields['other_image_url8']] = '';//同上，随着图片数量相应填入
            $row[$fields['swatch_image_url']] = '';//尺码图，固定链接，分站点
            $row[$fields['fulfillment_center_id']] = '';
            $row[$fields['package_height']] = '';
            $row[$fields['package_width']] = '';
            $row[$fields['package_length']] = '';
            $row[$fields['package_length_unit_of_measure']] = '';
            $row[$fields['package_weight']] = '';
            $row[$fields['package_weight_unit_of_measure']] = '';
            $row[$fields['parent_child']] = 'child';
            $row[$fields['parent_sku']] = $sku['sku'];
            $row[$fields['relationship_type']] = 'variation';
            $row[$fields['variation_theme']] = 'Size/Color';
            $row[$fields['prop_65']] = '';
            $row[$fields['cpsia_cautionary_description']] = '';
            $row[$fields['cpsia_cautionary_statement1']] = '';
            $row[$fields['cpsia_cautionary_statement2']] = '';
            $row[$fields['cpsia_cautionary_statement3']] = '';
            $row[$fields['cpsia_cautionary_statement4']] = '';
            $row[$fields['style_name']] = self::getData('keyword', $data['keyword'][0]);
            $row[$fields['lens_color']] = '';
            $row[$fields['lens_color_map']] = '';
            $row[$fields['magnification_strength']] = '';
            $row[$fields['frame_material_type']] = '';
            $row[$fields['lens_material_type']] = '';
            $row[$fields['item_shape']] = '';
            $row[$fields['polarization_type']] = '';
            $row[$fields['lens_width']] = '';
            $row[$fields['bridge_width']] = '';
            $row[$fields['arm_length']] = '';
            $row[$fields['lens_height']] = '';
            $row[$fields['eyewear_unit_of_measure']] = '';
            $row[$fields['closure_type']] = self::getData('closure', $data['closure']);
            $row[$fields['department_name']] = 'women';
            $row[$fields['color_name']] = $sku['colorName'];
            $row[$fields['color_map']] = self::getData('color_map', $sku['colorMap']);
            $row[$fields['import_designation']] = '';
            $row[$fields['country_as_labeled']] = '';
            $row[$fields['fur_description']] = '';
            $row[$fields['lifestyle']] = self::getData('lifestyle', $data['lifestyle']);
            $row[$fields['special_features1']] = self::getData('feature', $data['feature'][0]);
            $row[$fields['special_features2']] = self::getData('feature', $data['feature'][1]);
            $row[$fields['special_features3']] = self::getData('feature', $data['feature'][2]);
            $row[$fields['subject_character1']] = '';
            $row[$fields['subject_character2']] = '';
            $row[$fields['subject_character3']] = '';
            $row[$fields['subject_character4']] = '';
            $row[$fields['subject_character5']] = '';
            $row[$fields['strap_type']] = self::getData('strap', $data['strap']);
            $row[$fields['lining_description']] = '';
            $row[$fields['shoulder_strap_drop']] = '';
            $row[$fields['shoulder_strap_drop_unit_of_measure']] = '';
            $row[$fields['size_name']] = '';
            $row[$fields['is_stain_resistant']] = '';
            $row[$fields['material_type1']] = self::getData('material', $data['material']);
            $row[$fields['material_type2']] = '';
            $row[$fields['material_type3']] = '';
            $row[$fields['pattern_type']] = self::getData('pattern', $data['pattern']);
            $row[$fields['model_year']] = date('Y');
            $row[$fields['shoe_dimension_unit_of_measure']] = '';
            $row[$fields['sole_material']] = '';
            $row[$fields['heel_type']] = self::getData('heel', $data['heel']);
            $row[$fields['height_map']] = $data['heightMap'];
            $row[$fields['toe_style']] = self::getData('toe', $data['toe']);
            $row[$fields['arch_type']] = 'neutral';
            $row[$fields['cleat_description']] = '';
            $row[$fields['cleat_material_type']] = '';
            $row[$fields['team_name']] = '';
            $row[$fields['shaft_height']] = $data['shaftHeight'];
            $row[$fields['minimum_circumference']] = $data['minimumCircumference'];
            $row[$fields['heel_height']] = $data['heelHeight'];
            $row[$fields['platform_height']] = $data['platformHeight'];
            $row[$fields['water_resistance_level']] = '';
            //TODO: generate image url
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * @param $data
    {
     * "name": "",
     * "model": "test",
     * "store": "",
     * "brand": "",
     * "price": "",
     * "currency": "",
     * "delivery": "",
     * "size": "",
     * "itemType": "",
     * "platformHeight": "",
     * "heelHeight": "",
     * "shaftHeight": "",
     * "minimumCircumference": "",
     * "heel": "",
     * "strap": "",
     * "closure": "",
     * "pattern": "",
     * "toe": "",
     * "lifestyle": "",
     * "material": "",
     * "heightMap": "",
     * "upc": "0",
     * "bulletPoint": ["","","","",""],
     * "keyword": ["","",""],
     * "feature": ["","",""],
     * "sku":[{"sku":"","colorName":"","colorMap":"","images":""}, ...]
     * }
     * @param $file
     */
    public static function generate($data, $file)
    {
        header('Content-Type: octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');

        $csv = fopen($file, 'w');

        fputcsv($csv, self::$head);
        fputcsv($csv, self::parent($data));

        $all = $data['sku'];
        unset($data['sku']);

        foreach ($all as $sku) {
            $children = self::children($sku, $data);
            foreach ($children as $child) {
                fputcsv($csv, $child);
            }
            ob_flush();
            flush();
        }

        fclose($csv);
    }
}
