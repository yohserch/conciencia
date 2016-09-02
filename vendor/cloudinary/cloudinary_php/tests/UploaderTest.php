<?php
$base = realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..');
require_once(join(DIRECTORY_SEPARATOR, array($base, 'src', 'Cloudinary.php')));
require_once(join(DIRECTORY_SEPARATOR, array($base, 'src', 'Uploader.php')));
require_once(join(DIRECTORY_SEPARATOR, array($base, 'src', 'Api.php')));

class UploaderTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        Cloudinary::reset_config();
        if (!Cloudinary::config_get("api_secret")) {
          $this->markTestSkipped('Please setup environment for Upload test to run');
        }
    }

    public function test_upload() {
        $result = Cloudinary\Uploader::upload("tests/logo.png");
        $this->assertEquals($result["width"], 241);
        $this->assertEquals($result["height"], 51);
        $expected_signature = Cloudinary::api_sign_request(array("public_id"=>$result["public_id"], "version"=>$result["version"]), Cloudinary::config_get("api_secret"));
        $this->assertEquals($result["signature"], $expected_signature);
    }

    public function test_rename() {
        $result = Cloudinary\Uploader::upload("tests/logo.png");
        Cloudinary\Uploader::rename($result["public_id"], $result["public_id"]."2");
        $api = new \Cloudinary\Api();      
        $this->assertNotNull($api->resource($result["public_id"]."2"));

        $result2 = Cloudinary\Uploader::upload("tests/favicon.ico");
        $error_thrown = FALSE;
        try {
          Cloudinary\Uploader::rename($result2["public_id"], $result["public_id"]."2");
          $error_thrown = TRUE;
        } catch (Exception $e) {}
        $this->assertFalse($error_thrown);
        Cloudinary\Uploader::rename($result2["public_id"], $result["public_id"]."2", array("overwrite"=>TRUE));
        $resource = $api->resource($result["public_id"]."2");
        $this->assertEquals($resource["format"], "ico");        
    }

    public function test_explicit() {
        $result = Cloudinary\Uploader::explicit("cloudinary", array("type"=>"twitter_name", "eager"=>array("crop"=>"scale", "width"=>"2.0")));        
        $url = cloudinary_url("cloudinary", array("type"=>"twitter_name", "crop"=>"scale", "width"=>"2.0", "format"=>"png", "version"=>$result["version"]));
        $this->assertEquals($result["eager"][0]["url"], $url);        
    }

    public function test_eager() {
        Cloudinary\Uploader::upload("tests/logo.png", array("eager"=>array("crop"=>"scale", "width"=>"2.0")));
    }

    public function test_headers() {
        Cloudinary\Uploader::upload("tests/logo.png", array("headers"=>array("Link: 1")));
        Cloudinary\Uploader::upload("tests/logo.png", array("headers"=>array("Link" => "1")));
    }

    public function test_text() {
        $result = Cloudinary\Uploader::text("hello world");
        $this->assertGreaterThan(1, $result["width"]);
        $this->assertGreaterThan(1, $result["height"]);
    }

    public function test_tags() {
        $api = new \Cloudinary\Api();      
        $result = Cloudinary\Uploader::upload("tests/logo.png");
        Cloudinary\Uploader::add_tag("tag1", $result["public_id"]);
        Cloudinary\Uploader::add_tag("tag2", $result["public_id"]);
        $info = $api->resource($result["public_id"]);
        $this->assertEquals($info["tags"], array("tag1", "tag2"));
        Cloudinary\Uploader::remove_tag("tag1", $result["public_id"]);
        $info = $api->resource($result["public_id"]);
        $this->assertEquals($info["tags"], array("tag2"));
        Cloudinary\Uploader::replace_tag("tag3", $result["public_id"]);
        $info = $api->resource($result["public_id"]);
        $this->assertEquals($info["tags"], array("tag3"));
    }

    public function test_use_filename() {
        $api = new \Cloudinary\Api();      
        $result = Cloudinary\Uploader::upload("tests/logo.png", array("use_filename"=>TRUE));
        $this->assertRegExp('/logo_[a-zA-Z0-9]{6}/', $result["public_id"]);
        $result = Cloudinary\Uploader::upload("tests/logo.png", array("use_filename"=>TRUE, "unique_filename"=>FALSE));
        $this->assertEquals("logo", $result["public_id"]);
    }
    
    public function test_allowed_formats() {
      	//should allow whitelisted formats if allowed_formats
      	$formats = array("png"); 
      	$result = Cloudinary\Uploader::upload("tests/logo.png", array("allowed_formats" => $formats));
      	$this->assertEquals($result["format"], "png");
    }

    public function test_allowed_formats_with_illegal_format() {
        //should prevent non whitelisted formats from being uploaded if allowed_formats is specified
        $error_found = FALSE;
        $formats = array("jpg"); 
        try{
          Cloudinary\Uploader::upload("tests/logo.png", array("allowed_formats" => $formats));
        } catch (Exception $e) {
        	$error_found = TRUE;
        }
        $this->assertTrue($error_found);
    }
    
    public function test_allowed_formats_with_format() {
      	//should allow non whitelisted formats if type is specified and convert to that type
      	$formats = array("jpg"); 
      	$result = Cloudinary\Uploader::upload("tests/logo.png", array("allowed_formats" => $formats, "format" => "jpg"));
      	$this->assertEquals("jpg", $result["format"]);
    }
    
    public function test_face_coordinates() {
        //should allow sending face coordinates
        $coordinates = array(array(120, 30, 109, 150), array(121, 31, 110, 151));
        $result = Cloudinary\Uploader::upload("tests/logo.png", array("face_coordinates" => $coordinates, "faces" => TRUE));
        $this->assertEquals($coordinates, $result["faces"]);

        $different_coordinates = array(array(122, 32, 111, 152));
        Cloudinary\Uploader::explicit($result["public_id"], array("face_coordinates" => $different_coordinates, "faces" => TRUE, "type" => "upload"));
        $api = new \Cloudinary\Api();
        $info = $api->resource($result["public_id"], array("faces" => true));
        $this->assertEquals($different_coordinates, $info["faces"]);
    }
    
    public function test_context() {
      	//should allow sending context
      	$context = array("caption" => "some caption", "alt" => "alternative");
      	$result = Cloudinary\Uploader::upload("tests/logo.png", array("context" => $context));
        $api = new \Cloudinary\Api();
      	$info = $api->resource($result["public_id"], array("context" => true));
      	$this->assertEquals(array("custom" => $context), $info["context"]);
    }
    
    public function test_cl_form_tag() {
        Cloudinary::config(array("cloud_name"=>"test123", "secure_distribution" => NULL, "private_cdn" => FALSE, "api_key" => "1234"));

        $form = cl_form_tag("http://callback.com", array("public_id"=>"hello", "form"=>array("class"=>"uploader")));
        $this->assertRegexp("/<form enctype='multipart\/form-data' action='https:\/\/api.cloudinary.com\/v1_1\/test123\/image\/upload' method='POST' class='uploader'>\n<input name='timestamp' type='hidden' value='\d+'\/>\n<input name='public_id' type='hidden' value='hello'\/>\n<input name='signature' type='hidden' value='[0-9a-f]+'\/>\n<input name='api_key' type='hidden' value='1234'\/>\n<\/form>/", $form);
    }
    public function test_cl_image_upload_tag() {
        Cloudinary::config(array("cloud_name"=>"test123", "secure_distribution" => NULL, "private_cdn" => FALSE, "api_key" => "1234"));

        $tag = cl_image_upload_tag("image", array("public_id"=>"hello", "html"=>array("class"=>"uploader")));
        $this->assertRegexp("/<input class='uploader cloudinary-fileupload' data-cloudinary-field='image' data-form-data='{\"timestamp\":\d+,\"public_id\":\"hello\",\"signature\":\"[0-9a-f]+\",\"api_key\":\"1234\"}' data-url='https:\/\/api.cloudinary.com\/v1_1\/test123\/auto\/upload' name='file' type='file'\/>/", $tag);
    }
  
    function test_manual_moderation() {
        // should support setting manual moderation status
        $resource = \Cloudinary\Uploader::upload("tests/logo.png", array("moderation"=>"manual"));    
        $this->assertEquals($resource["moderation"][0]["status"], "pending");
        $this->assertEquals($resource["moderation"][0]["kind"], "manual");
    }
    
    /**
     * @expectedException \Cloudinary\Error
     * @expectedExceptionMessage illegal is not a valid
     */
    function test_raw_conversion() {
        // should support requesting raw_convert 
        \Cloudinary\Uploader::upload("tests/docx.docx", array("resource_type"=>"raw", "raw_convert" => "illegal"));    
    }
  
    /**
     * @expectedException \Cloudinary\Error
     * @expectedExceptionMessage illegal is not a valid
     */
    function test_categorization() {
        // should support requesting categorization 
        \Cloudinary\Uploader::upload("tests/logo.png", array("categorization" => "illegal"));
    }
  
    /**
     * @expectedException \Cloudinary\Error
     * @expectedExceptionMessage illegal is not a valid
     */
    function test_detection() {
        // should support requesting detection 
        \Cloudinary\Uploader::upload("tests/logo.png", array("detection" => "illegal"));
    }
  
    /**
     * @expectedException \Cloudinary\Error
     * @expectedExceptionMessage Must use
     */
    function test_auto_tagging() {
        // should support requesting auto_tagging 
        \Cloudinary\Uploader::upload("tests/logo.png", array("auto_tagging" => 0.5));
    }
    
    /**
     * @expectedException \Cloudinary\Error
     * @expectedExceptionMessage illegal is not a valid
     */
    function test_background_removal() {
        // should support requesting background_removal 
        \Cloudinary\Uploader::upload("tests/logo.png", array("background_removal" => "illegal"));
    }

    function test_large_upload() {
        \Cloudinary\Uploader::upload_large("tests/docx.docx");          
    }

    function test_upload_preset() {
      // should support unsigned uploading using presets
      $api = new \Cloudinary\Api();
      $preset = $api->create_upload_preset(array("folder"=>"upload_folder", "unsigned"=>TRUE));
      $result = \Cloudinary\Uploader::unsigned_upload("tests/logo.png", $preset["name"]);
      $this->assertRegExp('/^upload_folder\/[a-z0-9]+$/', $result["public_id"]);
      $api->delete_upload_preset($preset["name"]);
    }    
}
?>
