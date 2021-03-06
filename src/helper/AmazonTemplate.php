<?php

namespace helper;

use data\Database;
use data\OMS;
use DB\SQL\Mapper;

/*
amazon template for US as default
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
class AmazonTemplate
{
    protected static $genericKeywordDictionary = '';
    protected static $header = [
        [
            'TemplateType=Shoes',
            'Version=2015.1008',
            ['The top 3 rows are for Amazon.com use only. Do not modify or delete the top 3 rows.', 'C1', 'I1'],
            ['Offer - These attributes are required to make your item buyable for customers on the site', 'J1', 'AC1'],
            ['Dimensions - These attributes specify the size and weight of a product', 'AD1', 'AK1'],
            ['Discovery - These attributes have an effect on how customers can find your product on the site using browse or search', 'AL1', 'BC1'],
            ['Images - These attributes provide links to images for a product', 'BD1', 'BM1'],
            ['Fulfillment - Use these columns to provide fulfillment-related information for either Amazon-fulfilled (FBA) or seller-fulfilled orders.', 'BN1', 'BT1'],
            ['Variation - Populate these attributes if your product is available in different variations (for example color or wattage)', 'BU1', 'BX1'],
            ['Compliance - Attributes used to comply with consumer laws in the country or region where the item is sold', 'BY1', 'CD1'],
            ['Ungrouped - These attributes create rich product listings for your buyers.', 'CE1', 'EF1']
        ],
        [
            'Seller SKU',
            'Product Name',
            'Product ID',
            'Product ID Type',
            'Brand',
            'Product Description',
            'Item Type',
            'Style Number',
            'Update Delete',
            'Standard Price',
            'Manufacturer\'s Suggested Retail Price',
            'Currency',
            'Product Tax Code',
            'Fulfillment Latency',
            'Launch Date',
            'Release Date',
            'Restock Date',
            'Quantity',
            'Sale Price',
            'Sale Start Date',
            'Sale End Date',
            'Max Aggregate Ship Quantity',
            'Item Package Quantity',
            'Offering Can Be Gift Messaged',
            'Is Gift Wrap Available',
            'Is Discontinued by Manufacturer?',
            'Registered Parameter',
            'Scheduled Delivery SKU List',
            'Shipping-Template',
            'Shipping Weight',
            'Website Shipping Weight Unit Of Measure',
            'Item Weight Unit Of Measure',
            'Item Weight',
            'Item Length Unit Of Measure',
            'Item Length',
            'Item Width',
            'Item Height',
            'Bullet Point1',
            'Bullet Point2',
            'Bullet Point3',
            'Bullet Point4',
            'Bullet Point5',
            'Search Terms1',
            'Search Terms2',
            'Search Terms3',
            'Search Terms4',
            'Search Terms5',
            'Style Keyword1',
            'Style Keyword2',
            'Style Keyword3',
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
            'Swatch Image URL',
            'Fulfillment Center ID',
            'Package height',
            'Package Width',
            'Package Length',
            'Package Length Unit Of Measure',
            'Package Weight',
            'Package Weight Unit Of Measure',
            'Parentage',
            'Parent SKU',
            'Relationship Type',
            'Variation Theme',
            'Consumer Notice',
            'CPSIA Warning Description',
            'Cpsia Warning1',
            'Cpsia Warning2',
            'Cpsia Warning3',
            'Cpsia Warning4',
            'Style Name',
            'Lens Color',
            'Lens Color Map',
            'Magnification Strength',
            'Frame Material Type',
            'Lens Material Type',
            'Item Shape',
            'Polarization Type',
            'Lens Width',
            'Bridge Width',
            'Arm Length',
            'Lens Height',
            'Eyewear Unit Of Measure',
            'Closure Type',
            'Department',
            'Color',
            'Color Map',
            'Import Designation',
            'Country as Labeled',
            'Fur Description',
            'Occasion Lifestyle',
            'Special Features1',
            'Special Features2',
            'Special Features3',
            'character1',
            'character2',
            'character3',
            'character4',
            'character5',
            'Strap Type',
            'Lining Description',
            'Shoulder Strap Drop',
            'Shoulder Strap Drop Unit Of Measure',
            'size',
            'Is Stain Resistant?',
            'Material Fabric1',
            'Material Fabric2',
            'Material Fabric3',
            'Pattern Style',
            'Model Year',
            'Shoe Dimension Unit Of Measure',
            'Sole Material',
            'Heel Type',
            'Shoe Height Map',
            'Toe Style',
            'Arch Type',
            'Cleat Description',
            'Cleat Material Type',
            'Team Name',
            'Shaft Height',
            'Boot Opening Circumference',
            'Heel Height',
            'Platform Height',
            'Water Resistance Level',
        ],
        // field name
        [
            'item_sku',//first line: model; others generated by sku,见说明
            'item_name',//name,见说明
            'external_product_id',//EAN码，如果勾选需要EAN，EAN和UPC是同一个意思
            'external_product_id_type',//EAN
            'brand_name',//brand
            'product_description',//固定内容
            'item_type',//itemType，不同的站点会有不同内容和填入方式
            'model',//first line empty; others generated by sku
            'update_delete',// 空
            'standard_price',//price
            'list_price',//空
            'currency',//currency
            'product_tax_code',//空
            'fulfillment_latency',//10
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
            'parent_sku',//父SKU
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
            'department_name',//womens
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
            'shoe_dimension_unit_of_measure',//CM
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
        ]
    ];

    /**
     * @param $type : 尺码类型（manufacture/stock）
     * @param $store: store name
     * @return array
     */
    protected static function getSize($type, $store)
    {
        $marketUnit = Store::get($store)['market_unit'];
        switch ($type) {
            case 'manufacture':
                if ($marketUnit == 'EU') {
                    return [35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46];
                } else if ($marketUnit == 'UK') {
                    return [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
                } else if ($marketUnit == 'US') {
                    return [5, 6, 7, 8, 9, 9.5, 10, 11, 12, 13, 14, 15];
                } else {
                    return [];
                }
            case 'stock':
                if ($marketUnit == 'EU') {
                    return [35.5, 36, 36.5, 37, 37.5, 38, 38.5, 39, 39.5, 40, 40.5, 41, 41.5, 42, 43, 44, 45];
                } else if ($marketUnit == 'UK') {
                    return [3, 3.5, 4, 4.5, 5, 5.5, 6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5, 10, 10.5, 11];
                } else if ($marketUnit == 'US') {
                    return [5, 5.5, 6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5, 10, 10.5, 11, 11.5, 12, 13, 14];
                } else {
                    return [];
                }
            default:
                return [];
        }
    }

    protected static function getDescription()
    {
        return <<<DES
<b>Onlymaker</b> is a shoes brand, synchronized with the latest fashion trend, taking dedicated handmade craft work as well as an attractive price.</br>

<b>Shipping method</b>: USPS or UPS package  5-10 days</br>
faster shipping or an urgent needing is still available, please contact us in detail.</br>

<b>Local return</b>:For any problem,  such as size or quality problems, please contact us first, we will try our best to solve it. </br>
If you still need a return, you can return the item to our US office. </br>

<b>Customization avaliable</b>: You can customize shoes, please contract us for detail, such as changing heel height, color, sole,
scripting the name even producing a new one with your idea.</br>

We aim to help women realize their dream of owning the perfect shoes. </br></br>

<b>Onlymaker makes your only shoes</b></br>
DES;

    }

    protected static function getUPC()
    {
        $upc = new Mapper(Database::mysql(), 'upc');
        $upc->load('status = 0', ['limit' => 1]);
        if ($upc->dry()) {
            \Base::instance()->log('WARNING: upc is empty');
            return '';
        } else {
            $upc['status'] = 1;
            $upc->save();
            return $upc['data'];
        }
    }

    protected static function getAutoKeywords($hints, $language = 'us')
    {
        if (!is_array(self::$genericKeywordDictionary)) {
            if (empty($hints)) {
                return [];
            } else {
                $names = explode(' ', addslashes($hints));
                $filter = '';
                foreach ($names as $name) {
                    $name = trim($name);
                    if (!empty($name)) {
                        $filter .= '\'' . $name . '\',';
                    }
                }
                $filter = '(' . substr($filter, 0, strlen($filter) - 1) . ')';
                $query = Database::mysql()->exec('SELECT * FROM generic_keyword WHERE name in ' . $filter);
                $results = '';
                foreach ($query as $item) {
                    $results .= $item[$language] . ',';
                }
                if (empty($results)) {
                    self::$genericKeywordDictionary = [];
                } else {
                    self::$genericKeywordDictionary = explode(',', substr($results, 0, strlen($results) - 1));
                }
            }
        }
        $keywords = [];
        if (self::$genericKeywordDictionary) {
            $max = count(self::$genericKeywordDictionary) - 1;
            for($i = 0; $i < 5; $i++) {
                $keyword = '';
                $string = '';
                $array = [];
                while (mb_strlen($string . ' '. $keyword) < 80) {
                    if (!empty($keyword)) {
                        $string .= ' ' . $keyword;
                        $array[] = $keyword;
                    }
                    $keyword = trim(self::$genericKeywordDictionary[rand(0, $max)]);
                }
                $keywords[] = implode(' ', array_unique($array));
            }
        }
        return $keywords;
    }

    protected static function getImages($storeName, $model) : array
    {
        $oms = OMS::instance();
        $prototype = new Mapper($oms, 'prototype');
        $prototype->load(['model = ?', trim($model)]);
        if ($prototype->dry()) {
            return [];
        } else {
            $images = $prototype['images'];
            if (empty($images)) {
                return [];
            } else {
                $store = Store::get($storeName);
                $results = explode(',', $images);
                foreach ($results as &$result) {
                    if (!empty($store['cdn'])) {
                        $result = str_replace('http://image.onlymaker.cn', $store['cdn'], $result);
                    }
                    if ($pos = strpos($result, 'imageView2')) {
                        $result = substr($result, 0, $pos);
                    } else {
                        $result = str_replace('_thumb', '', $result);
                    }
                }
                return $results;
            }
        }
    }

    protected static function getSwatchImageUrl($type, $storeName)
    {
        if ($type == 'stock') {
            $imageUrl = 'http://' . strtolower($storeName) . '.syncxplus.com/stock_size_chart.png';
        } else {
            $store = Store::get($storeName);
            $imageUrl = $store['swatch_image_url'];
        }
        return $imageUrl ?? '';
    }

    protected static function parent($data)
    {
        $fields = array_flip(self::$header[2]);
        $row = [$data['store'] . '-' . $data['model']];
        $row[$fields['item_name']] = $data['name'];
        $row[$fields['external_product_id']] = '';
        $row[$fields['external_product_id_type']] = '';
        $row[$fields['brand_name']] = $data['brand'];
        $row[$fields['product_description']] = self::getDescription();
        $row[$fields['item_type']] = $data['itemType'];
        $row[$fields['model']] = $row[$fields['item_sku']];
        $row[$fields['update_delete']] = '';
        $row[$fields['standard_price']] = $data['price'];
        $row[$fields['list_price']] = '';
        $row[$fields['currency']] = $data['currency'];
        $row[$fields['product_tax_code']] = '';
        $row[$fields['fulfillment_latency']] = 10;
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
        $row[$fields['bullet_point1']] = $data['bulletPoint'][0];
        $row[$fields['bullet_point2']] = $data['bulletPoint'][1];
        $row[$fields['bullet_point3']] = $data['bulletPoint'][2];
        $row[$fields['bullet_point4']] = $data['bulletPoint'][3];
        $row[$fields['bullet_point5']] = $data['bulletPoint'][4];

        $autoKeywords = self::getAutoKeywords($data['name']);
        $row[$fields['generic_keywords1']] = $autoKeywords[0];
        $row[$fields['generic_keywords2']] = $autoKeywords[1];
        $row[$fields['generic_keywords3']] = $autoKeywords[2];
        $row[$fields['generic_keywords4']] = $autoKeywords[3];
        $row[$fields['generic_keywords5']] = $autoKeywords[4];

        $row[$fields['style_keywords1']] = $data['keyword'][0];
        $row[$fields['style_keywords2']] = $data['keyword'][1];
        $row[$fields['style_keywords3']] = $data['keyword'][2];
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
        $row[$fields['style_name']] = $data['keyword'][0];
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
        $row[$fields['closure_type']] = $data['closure'];
        $row[$fields['department_name']] = 'womens';
        $row[$fields['color_name']] = '';
        $row[$fields['color_map']] = '';
        $row[$fields['import_designation']] = '';
        $row[$fields['country_as_labeled']] = '';
        $row[$fields['fur_description']] = '';
        $row[$fields['lifestyle']] = $data['lifestyle'];
        $row[$fields['special_features1']] = $data['feature'][0];
        $row[$fields['special_features2']] = $data['feature'][1];
        $row[$fields['special_features3']] = $data['feature'][2];
        $row[$fields['subject_character1']] = '';
        $row[$fields['subject_character2']] = '';
        $row[$fields['subject_character3']] = '';
        $row[$fields['subject_character4']] = '';
        $row[$fields['subject_character5']] = '';
        $row[$fields['strap_type']] = $data['strap'];
        $row[$fields['lining_description']] = '';
        $row[$fields['shoulder_strap_drop']] = '';
        $row[$fields['shoulder_strap_drop_unit_of_measure']] = '';
        $row[$fields['size_name']] = '';
        $row[$fields['is_stain_resistant']] = '';
        $row[$fields['material_type1']] = $data['material'];
        $row[$fields['material_type2']] = '';
        $row[$fields['material_type3']] = '';
        $row[$fields['pattern_type']] = $data['pattern'];
        $row[$fields['model_year']] = date('Y');
        $row[$fields['shoe_dimension_unit_of_measure']] = 'CM';
        $row[$fields['sole_material']] = '';
        $row[$fields['heel_type']] = $data['heel'];
        $row[$fields['height_map']] = $data['heightMap'];
        $row[$fields['toe_style']] = $data['toe'];
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

    protected static function children($sku, $data)
    {
        $rows = [];
        $fields = array_flip(self::$header[2]);
        $marketUnit = Store::get($data['store'])['market_unit'];
        $sizeArray = self::getSize($data['size'], $data['store']);
        foreach ($sizeArray as $size) {
            $row = [$data['store'] . '-' . $sku['sku'] . '-' . $marketUnit . $size];
            $row[$fields['item_name']] = $data['name'] . '-' . $sku['colorName'] . '-' . $size;
            $row[$fields['external_product_id']] = $data['upc'] == 1 ? self::getUPC() : '';
            $row[$fields['external_product_id_type']] = empty($row[$fields['external_product_id']]) ? '' : 'EAN';
            $row[$fields['brand_name']] = $data['brand'];
            $row[$fields['product_description']] = self::getDescription();
            $row[$fields['item_type']] = $data['itemType'];
            $row[$fields['model']] = $row[$fields['item_sku']];
            $row[$fields['update_delete']] = '';
            $row[$fields['standard_price']] = $data['price'];
            $row[$fields['list_price']] = '';
            $row[$fields['currency']] = $data['currency'];
            $row[$fields['product_tax_code']] = '';
            $row[$fields['fulfillment_latency']] = 10;
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
            $row[$fields['bullet_point1']] = $data['bulletPoint'][0];
            $row[$fields['bullet_point2']] = $data['bulletPoint'][1];
            $row[$fields['bullet_point3']] = $data['bulletPoint'][2];
            $row[$fields['bullet_point4']] = $data['bulletPoint'][3];
            $row[$fields['bullet_point5']] = $data['bulletPoint'][4];

            $autoKeywords = self::getAutoKeywords($data['name']);
            $row[$fields['generic_keywords1']] = $autoKeywords[0];
            $row[$fields['generic_keywords2']] = $autoKeywords[1];
            $row[$fields['generic_keywords3']] = $autoKeywords[2];
            $row[$fields['generic_keywords4']] = $autoKeywords[3];
            $row[$fields['generic_keywords5']] = $autoKeywords[4];

            $row[$fields['style_keywords1']] = $data['keyword'][0];
            $row[$fields['style_keywords2']] = $data['keyword'][1];
            $row[$fields['style_keywords3']] = $data['keyword'][2];
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
                    $row[$fields['swatch_image_url']] = self::getSwatchImageUrl($data['size'], $data['store']);
                } else {
                    $row[$fields['other_image_url' . ++ $length]] = self::getSwatchImageUrl($data['size'], $data['store']);
                    $row[$fields['swatch_image_url']] = '';
                }
            } else {
                $row[$fields['main_image_url']] = self::getSwatchImageUrl($data['size'], $data['store']);
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

            $row[$fields['fulfillment_center_id']] = '';
            $row[$fields['package_height']] = '';
            $row[$fields['package_width']] = '';
            $row[$fields['package_length']] = '';
            $row[$fields['package_length_unit_of_measure']] = '';
            $row[$fields['package_weight']] = '';
            $row[$fields['package_weight_unit_of_measure']] = '';
            $row[$fields['parent_child']] = 'child';
            $row[$fields['parent_sku']] = $data['store'] . '-' . $data['model'];
            $row[$fields['relationship_type']] = 'variation';
            $row[$fields['variation_theme']] = 'Size/Color';
            $row[$fields['prop_65']] = '';
            $row[$fields['cpsia_cautionary_description']] = '';
            $row[$fields['cpsia_cautionary_statement1']] = '';
            $row[$fields['cpsia_cautionary_statement2']] = '';
            $row[$fields['cpsia_cautionary_statement3']] = '';
            $row[$fields['cpsia_cautionary_statement4']] = '';
            $row[$fields['style_name']] = $data['keyword'][0];
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
            $row[$fields['closure_type']] = $data['closure'];
            $row[$fields['department_name']] = 'womens';
            $row[$fields['color_name']] = $sku['colorName'];
            $row[$fields['color_map']] = $sku['colorMap'];
            $row[$fields['import_designation']] = '';
            $row[$fields['country_as_labeled']] = '';
            $row[$fields['fur_description']] = '';
            $row[$fields['lifestyle']] =$data['lifestyle'];
            $row[$fields['special_features1']] = $data['feature'][0];
            $row[$fields['special_features2']] = $data['feature'][1];
            $row[$fields['special_features3']] = $data['feature'][2];
            $row[$fields['subject_character1']] = '';
            $row[$fields['subject_character2']] = '';
            $row[$fields['subject_character3']] = '';
            $row[$fields['subject_character4']] = '';
            $row[$fields['subject_character5']] = '';
            $row[$fields['strap_type']] = $data['strap'];
            $row[$fields['lining_description']] = '';
            $row[$fields['shoulder_strap_drop']] = '';
            $row[$fields['shoulder_strap_drop_unit_of_measure']] = '';
            $row[$fields['size_name']] = $marketUnit . $size;
            $row[$fields['is_stain_resistant']] = '';
            $row[$fields['material_type1']] = $data['material'];
            $row[$fields['material_type2']] = '';
            $row[$fields['material_type3']] = '';
            $row[$fields['pattern_type']] = $data['pattern'];
            $row[$fields['model_year']] = date('Y');
            $row[$fields['shoe_dimension_unit_of_measure']] = 'CM';
            $row[$fields['sole_material']] = '';
            $row[$fields['heel_type']] = $data['heel'];
            $row[$fields['height_map']] = $data['heightMap'];
            $row[$fields['toe_style']] = $data['toe'];
            $row[$fields['arch_type']] = 'neutral';
            $row[$fields['cleat_description']] = '';
            $row[$fields['cleat_material_type']] = '';
            $row[$fields['team_name']] = '';
            $row[$fields['shaft_height']] = $data['shaftHeight'];
            $row[$fields['minimum_circumference']] = $data['minimumCircumference'];
            $row[$fields['heel_height']] = $data['heelHeight'];
            $row[$fields['platform_height']] = $data['platformHeight'];
            $row[$fields['water_resistance_level']] = '';

            $rows[] = $row;
        }
        return $rows;
    }

    protected static function writeRow(\PHPExcel_Worksheet $sheet, int $rowNumber, array $data)
    {
        $row = $sheet->getRowIterator($rowNumber)->current();
        $cell = $row->getCellIterator();
        foreach ($data as $item) {
            if (is_array($item)) {
                $cell->current()->setValue($item[0])->setDataType(\PHPExcel_Cell_DataType::TYPE_STRING);
                if (count($item) == 3) {
                    $sheet->mergeCells($item[1] . ':' . $item[2]);
                    $cell = $row->getCellIterator(substr($item[2], 0, strlen($item[2]) - 1));
                }
            } else {
                $cell->current()->setValue($item)->setDataType(\PHPExcel_Cell_DataType::TYPE_STRING);
            }
            $cell->next();
        }
    }

    public static function generate($data, $file)
    {
        \PHPExcel_Settings::setCacheStorageMethod(\PHPExcel_CachedObjectStorageFactory::cache_to_discISAM, ['memoryCacheSize' => '16M']);

        $row = 1;
        $excel = new \PHPExcel();
        $excel->setActiveSheetIndex(0);
        self::writeRow($excel->getActiveSheet(), $row, self::$header[0]);
        $excel->getActiveSheet()->fromArray(self::$header[1], '', 'A' . ++ $row);
        $excel->getActiveSheet()->fromArray(self::$header[2], '', 'A' . ++ $row);
        $excel->getActiveSheet()->fromArray(self::parent($data), '', 'A' . ++ $row);

        $all = $data['sku'];
        unset($data['sku']);

        foreach ($all as $sku) {
            if (!empty($sku['sku'])) {
                $children = self::children($sku, $data);
                foreach ($children as $child) {
                    $excel->getActiveSheet()->fromArray($child, '', 'A' . ++ $row);
                }
            }
        }

        $writer = new \PHPExcel_Writer_Excel5($excel);
        $writer->save($file);
    }

    public static function printHeader($file, $maxHeaderRow = 3)
    {
        $tmp = '/tmp/' . basename($file, ".xls") . '.header';
        if (is_file($tmp)) {
            unlink($tmp);
        }

        $excel = \PHPExcel_IOFactory::load($file);
        $sheet = $excel->getSheet(0);

        $rowIterator = $sheet->getRowIterator();
        foreach ($rowIterator as $row) {
            if ($row->getRowIndex() <= $maxHeaderRow) {
                file_put_contents($tmp, $row->getRowIndex() . ": [\n", FILE_APPEND);
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells();
                foreach ($cellIterator as $cell) {
                    $value = trim($cell->getValue());
                    if (!empty($value)) {
                        $value = addslashes(preg_replace('/\f|\n|\r|\t|\v/', '', $value));
                        if ($cell->isMergeRangeValueCell()) {
                            $bounds = explode(':', $cell->getMergeRange());
                            file_put_contents($tmp, "    ['$value', '$bounds[0]', '$bounds[1]'],\n", FILE_APPEND);
                        } else {
                            file_put_contents($tmp, "    '$value',\n", FILE_APPEND);
                        }
                    }
                }
                file_put_contents($tmp, "],\n", FILE_APPEND);
            }
        }
    }
}
