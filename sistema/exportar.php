<?php  include('config/config.php');



    session_start();
    if (!isset($_SESSION['Sis545IdUsuario'])) {
        session_destroy();
        header("Location: ".$Config['Url']."login.php");
        exit;
    }

class Excel_XML
{
    private $header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?\>
<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
 xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
 xmlns:html=\"http://www.w3.org/TR/REC-html40\">";


    private $footer = "</Workbook>";


    private $lines = array ();


    private $worksheet_title = "Table1";

 
    private function addRow ($array)
    {

  
        $cells = "";


        foreach ($array as $k => $v):

            $cells .= "<Cell><Data ss:Type=\"String\">" . utf8_encode($v) . "</Data></Cell>\n"; 

        endforeach;

        
        $this->lines[] = "<Row>\n" . $cells . "</Row>\n";

    }

  
    public function addArray ($array)
    {

  
        foreach ($array as $k => $v):
            $this->addRow ($v);
        endforeach;

    }

 
    public function setWorksheetTitle ($title)
    {

        
        $title = preg_replace ("/[\\\|:|\/|\?|\*|\[|\]]/", "", $title);

        
        $title = substr ($title, 0, 31);

        
        $this->worksheet_title = $title;

    }


    function generateXML ($filename)
    {


        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Content-Disposition: inline; filename=\"" . $filename . ".xls\"");


        echo stripslashes ($this->header);
        echo "\n<Worksheet ss:Name=\"" . $this->worksheet_title . "\">\n<Table>\n";
        echo "<Column ss:Index=\"1\" ss:AutoFitWidth=\"0\" ss:Width=\"110\"/>\n";
        echo implode ("\n", $this->lines);
        echo "</Table>\n</Worksheet>\n";
        echo $this->footer;

    }

}

    $table = '';

    if(isset($_GET[1]) && $_GET[1]!=''){
        $table = clean($_GET[1]);
    }else{
        echo 'erro';
        exit;
    }

    $doc = array (
        );

    $header = array();

    array_push($header,ucfirst($table));

    foreach($Gerenciamentos[$table] as $label => $v){    
        array_push($header,$label);
    }

    array_push($header,'Ativo');
    array_push($doc,$header);   


    $q = Query("SELECT * FROM $table");

    while($r = mysqli_fetch_assoc($q)){

        $linha = array();
        array_push($linha,$r[ucfirst($table)]);

        foreach($Gerenciamentos[$table] as $label => $v){    
            array_push($linha,$r[$label]);
        }  

         array_push($linha,$r['Ativo']);
         array_push($doc,$linha);                 

    }

    $xls = new Excel_XML;
    $xls->addArray ($doc);
    $xls->generateXML($table);

?>