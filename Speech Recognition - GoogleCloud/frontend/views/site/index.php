<?php
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/** @var yii\web\View $this */

$this->title = 'Api Speech';

?>


<div class="col-lg-12 text-center p-inicio">
 
    <section style="margin:20px 0px 40px 0px">
    <?php
        echo '<label class="control-label">Up your MP3 English File! (For test you can to download mp3 here <a href="english.mp3">clic</a>)</label>';
       
        echo FileInput::widget([
            'name' => 'videoattach',
            'options'=>[
                'multiple'=>false,
                'id' => 'identyaudio'
            ],
            'pluginOptions' => [
                'uploadUrl' =>'http://18.223.105.203:8086//development/speechapi/web/index.php?r=site/uploadaudio',
                'showPreview' => false,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => true,
                'maxFileSize'=>2800,
                'allowedFileExtensions'=> ["mp3"]
            ]
        ]);
    ?>    
    </section>    
        
    
    <div style="text-align: left !important">
        <h3>Text:</h3>
        
        <div  id="transcribe_text" class="col-lg-12">
            
        </div>
    </div>
    
    
    <div id="step2" style="text-align: left !important;display:none">
        
        <h3>Custom your Search...</h3>
        
        <div id="search">
            
                 Word Search: <input type="text" id="wordsearch" />
                 <button type="submit" class="btn btn-primary " id="btnsearch">Search</button>
        </div>   
        
        <div style="clear: both">&nbsp;</div>
        
        <div id="result_search">
          
            <table class="table" width="100%" >
            <thead>
              <tr>
                <th scope="col">Word</th>
                <th scope="col">Number of Findings</th>
                <th scope="col">TimeStamp (seconds)</th>
              </tr>
            </thead>
            <tbody id="tableresults">
            
            </tbody>
          </table>
            
        </div>    
        
    </div>
    
    
</div>
<?php
$script = <<< JS
  
  //Declare Variables 
  var words;
  var session;
 
      
  /*
       Function to capture de event on load file 
  */
  $('#identyaudio').on('fileuploaded', function(event, data, previewId, index) {
    
    //Get Answer    
    var response = data.response;
    console.log('File uploaded triggered:',response);
    
    //Put text on div
    $( "#transcribe_text" ).html("<p>"+response.text+"</p>");     
    
    words = response.words;               
    session = response.session;    
    //Enabled step2
    $('#step2').show();  
  });
        
        
        
  /*Function for disable step 2*/
   $("#identyaudio").on("click", function() {
       $('#step2').hide();  
       $( "#transcribe_text" ).html("");    
       $( "#tableresults" ).html("");        
   });
        
  
   /*Function to search word for client*/
   $("#btnsearch").on("click", function() {
       
        var wordtofind = document.getElementById("wordsearch").value;
        if(words[wordtofind] != undefined){
            var strapp = "<tr><td>"+wordtofind+"</td><td>"+words[wordtofind].count+"</td><td>"+words[wordtofind].time+"</td></tr>";
            var url = 'http://18.223.105.203:8086/development/speechapi/web/index.php?r=site/createeventajax&video='+session+'&word='+wordtofind+'&type=3&description=Word:'+wordtofind+' Count:'+words[wordtofind].count+' Time:'+words[wordtofind].time;
        }else{
            var strapp = "<tr><td>"+wordtofind+"</td><td>0</td><td> Not Found</td></tr>";
            var url = 'http://18.223.105.203:8086/development/speechapi/web/index.php?r=site/createevent&video='+session+'&word='+wordtofind+'&type=3&description=Word:'+wordtofind+' Not Found';
        }
        
        $("#tableresults").append(strapp);
        
        
        /*ajax to save query user*/
        $.ajax({
            url: url,
            type: 'get',
            success: function (data) {
               console.log('resultado',data);
            }
       });
       //console.log("se obtiene:",words[wordtofind] );
   });     
        
        
        
  
JS;
$this->registerJs($script);
?>