<?php
    require_once '../../php/bancodedados/connect.class.php';
    require_once '../../php/class/bolsista.class.php';
    require_once '../../php/class/funcao.class.php';
    class Escala{
        private $conn;
        private $bolsista;
        private $funcoes;
        private $escala;
        private $semana = ["segunda","terca","quarta","quinta","sexta"];

        function __construct(){
            $this->bolsista = new Bolsista();
            $this->funcoes = new Funcao();
            $this->conn = mysqli_connect("localhost", "root", "", "sisgesbd");
        }
        public function gerarEscala(){
            $this->escala = [];
            for($dia = 0; $dia<5;$dia++){
                $this->escala[$this->semana[$dia]] = $this->gerar();
            }
            return $this->escala;
        }
        public function gerar(){
            $array = [];
            $array["manha"] = $this->gerarManha();
            $array["tarde"] = $this->gerarTarde();
            $array["noite"] = $this->gerarNoite();
            return $array;
        }
        public function gerarManha(){
            $array =[];
            if($this->bolsista->getNumBolsista('M') == $this->funcoes->getNumFuncoes()){
                $arrBol = $this->arrayBol('M'); 
                $arrFun = $this->arrayFun();
                $num = count($arrFun) - 1;
                for($i = 0;$i < $this->bolsista->getNumBolsista('M');$i++){
                    while(count($arrFun)!=0){
                        $var = rand(0, $num);   
                        if(array_key_exists($var, $arrFun)){
                            break;
                        }
                    }
                    array_push($array, [$arrBol[$i][0],$arrFun[$var][1]]);
                    unset($arrFun[$var]);
                }
            }else{
                $arrBol = $this->arrayBol('M'); 
                $arrFun = $this->arrayFunOther();
                $num = count($arrFun) - 1;
                for($i = 0;$i < $this->bolsista->getNumBolsista('M');$i++){
                    while(count($arrFun)!=0){
                        $var = rand(0, $num);   
                        if(array_key_exists($var, $arrFun)){
                            break;
                        }
                    }
                    array_push($array, [$arrBol[$i][0],$arrFun[$var][1]]);
                    unset($arrFun[$var]);
                }
            }
            return $array;
        }
        private function gerarTarde(){
            $array =[];
            if($this->bolsista->getNumBolsista('T') == $this->funcoes->getNumFuncoes()){
                $arrBol = $this->arrayBol('T'); 
                $arrFun = $this->arrayFun();
                $num = count($arrFun) - 1;
                for($i = 0;$i < $this->bolsista->getNumBolsista('T');$i++){
                    while(count($arrFun)!=0){
                        $var = rand(0, $num);   
                        if(array_key_exists($var, $arrFun)){
                            break;
                        }
                    }
                    array_push($array, [$arrBol[$i][0],$arrFun[$var][1]]);
                    unset($arrFun[$var]);
                }
            }else{
                $arrBol = $this->arrayBol('T'); 
                $arrFun = $this->arrayFunOther();
                $num = count($arrFun) - 1;
                for($i = 0;$i < $this->bolsista->getNumBolsista('T');$i++){
                    while(count($arrFun)!=0){
                        $var = rand(0, $num);   
                        if(array_key_exists($var, $arrFun)){
                            break;
                        }
                    }
                    array_push($array, [$arrBol[$i][0],$arrFun[$var][1]]);
                    unset($arrFun[$var]);
                }
            }
            return $array;
        }
        private function gerarNoite(){
            $array =[];
            if($this->bolsista->getNumBolsista('N') ==  $this->funcoes->getNumFuncoes()){
                $arrBol = $this->arrayBol('N'); 
                $arrFun = $this->arrayFun();
                $num = count($arrFun) - 1;
                for($i = 0;$i < $this->bolsista->getNumBolsista('N');$i++){
                    while(count($arrFun)!=0){
                        $var = rand(0, $num);   
                        if(array_key_exists($var, $arrFun)){
                            break;
                        }
                    }
                    array_push($array, [$arrBol[$i][0],$arrFun[$var][1]]);
                    unset($arrFun[$var]);
                }
            }else{
                $arrBol = $this->arrayBol('N'); 
                $arrFun = $this->arrayFunOther();
                $num = count($arrFun) - 1;
                for($i = 0;$i < $this->bolsista->getNumBolsista('N');$i++){
                    while(count($arrFun)!=0){
                        $var = rand(0, $num);   
                        if(array_key_exists($var, $arrFun)){
                            break;
                        }
                    }
                    array_push($array, [$arrBol[$i][0],$arrFun[$var][1]]);
                    unset($arrFun[$var]);
                }
            }
            return $array;
        }

        public function arrayBol($t){
            $arr =[];
            $bolsista = mysqli_query($this->conn,"SELECT * from bolsistas where horario='$t'");
            while ($row = mysqli_fetch_array($bolsista)) {
                array_push($arr, [$row["id"],$row["nome"],$row["horario"]]);
            }
            return $arr;
            //var_dump($arr);
        }
        public function arrayFun(){
            $arr =[];
            $funcao = mysqli_query($this->conn,"SELECT * from funcoes");
            while ($row = mysqli_fetch_array($funcao)){
                array_push($arr, [$row["id"],$row["nome"]]);
            }
            return $arr;
            //var_dump($arr);
        }
        public function arrayFunOther(){
            $arr =[];
            $funcao = mysqli_query($this->conn,"SELECT * from funcoes");
            while ($row = mysqli_fetch_array($funcao)){
                for($n = 1; $n<=$row["qnt"]; $n++){
                    array_push($arr, [$row["id"],$row["nome"]]);
                }
            }
            return $arr;
            //var_dump($arr);
        }
        public function name($id){
            $int = intval($id);
            $sql = "SELECT nome, horas FROM bolsistas WHere id = $int";
            $result = mysqli_query($this->conn, $sql);
            while($row = mysqli_fetch_assoc($result)) {
                $nome = $row['nome'];
                $horas = $row['horas'];
            }
            return $nome.' '.$horas;
        }
        public function exibir($numBol,$arr,$turno){
            for($x = 0;$x<$numBol; $x++){
                echo '
                    <tr>
                        <td><b>'.$this->name($arr["segunda"][$turno][$x][0]).'</b></td>
                        <td>'.$arr["segunda"][$turno][$x][1].'</td>
                        <td>'.$arr["terca"][$turno][$x][1].'</td>
                        <td>'.$arr["quarta"][$turno][$x][1].'</td>
                        <td>'.$arr["quinta"][$turno][$x][1].'</td>
                        <td>'.$arr["sexta"][$turno][$x][1].'</td>
                    </tr>    
                ';
            }
        }
        public function gerou(){
            $arr = $this->gerarEscala();
            echo '
                <table class="table table-bordered table-hover">
                <tr class = "success">
                    <td colspan="6" style="text-align:center"><b>Manha</b></td>
                </tr>
                <thead>
                <tr>
                <th>Bolsista</th>
                <th>Segunda</th> 
                <th>Terça</th>
                <th>Quarta</th>
                <th>Quinta</th>
                <th>Sexta</th>
                <thead>
                <tbody>
                </tr>';
            $this->exibir($this->bolsista->getNumBolsista('M'),$arr,"manha");
            echo '<tr class = "info"><td colspan="6" style="text-align:center"><b>Tarde</b></td></tr>';
            $this->exibir($this->bolsista->getNumBolsista('T'),$arr,"tarde");
            echo '<tr class = "danger"><td colspan="6" style="text-align:center"><b>Noite</b></td></tr>';
            $this->exibir($this->bolsista->getNumBolsista('N'),$arr,"noite");
            echo '    
                </tbody>
                </table>';
            $decode = json_encode($arr);
            echo "<input name='escala' id='escala' type='hidden' value='$decode' >";
            //var_dump($decode);
        }
        public function salvar($data,$arr){
            mysqli_query($this->conn, "INSERT INTO escalas(dia,supervisor,dados) VALUES ('$data','user','$arr')");
        }
        public function listar(){
            $result = mysqli_query($this->conn,"Select * from escalas");
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    echo '
                    <tr>
                        <td>'.$row['id'].'</td>
                        <td>'.$row['dia'].'</td>
                        <td>
                            <input class="btn btn-primary" type="button" onclick=ver('.$row['id'].') value="Ver">
                            <input onclick=define_del('.$row['id'].') class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal-default" value="Deletar">
                        </td>
                    </tr>
                ';
                }
            } else {
                echo "0 results";
            }
            
        }
        public function exibir_escala($id){
            $arr;
            $dia;
            $int = intval($id);
            $result = mysqli_query($this->conn, "SELECT * FROM escalas WHERE id = $int");
            while($row = mysqli_fetch_array($result)){
                $dia = $row['dia'];
                $arr = json_decode($row['dados'], true);
            }
            echo '
                <table id="example1" class="table table-bordered table-hover">
                <tr class = "success">
                    <td colspan="6" style="text-align:center"><b>Manhã</b></td>
                </tr>
                <thead>
                <tr>
                <th>Bolsista</th>
                <th>Segunda</th> 
                <th>Terça</th>
                <th>Quarta</th>
                <th>Quinta</th>
                <th>Sexta</th>
                <thead>
                <tbody>
                </tr>';
            $this->exibir($this->bolsista->getNumBolsista('M'),$arr,"manha");
            echo '<tr class = "info"><td colspan="6" style="text-align:center"><b>Tarde</b></td></tr>';
            $this->exibir($this->bolsista->getNumBolsista('T'),$arr,"tarde");
            echo '<tr class = "danger"><td colspan="6" style="text-align:center"><b>Noite</b></td></tr>';
            $this->exibir($this->bolsista->getNumBolsista('N'),$arr,"noite");
            echo "
                </tbody>
                </table>
                
                <input type='hidden' id='dia' value =$dia>
                <input type='hidden' id='idd' value=$id>"
                ;
        }
        public function deletar($id){
            $int = intval($id);
            $sql = "DELETE FROM escalas WHERE id = $int";
            mysqli_query($this->conn, $sql);
        }
        public function gerar_html($id){
            $arr;
            $int = intval($id);
            $result = mysqli_query($this->conn, "SELECT * FROM escalas WHERE id = $int");
            while($row = mysqli_fetch_array($result)){
                $dia = $row['dia'];
                $arr = json_decode($row['dados'], true);
            }

            $html ='
            <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
            <h3 style="text-align:center">Escala gerada - '.$dia.'</h3><br>
            <table class="table table-bordered table-hover">
            <tbody>
            <tr>
                <th>Bolsista</td>
                <th>Segunda</td>
                <th>Terça</td>
                <th>Quarta</td>
                <th>Quinta</td>
                <th>Sexta</td>
            </tr>
            <tr class="success">
                <td colspan="6" style="text-align:center"><b>Manhã<b></td>
            </tr>
            ';
            for($x = 0;$x< $this->bolsista->getNumBolsista('M'); $x++){
                $html = $html . '
                    <tr>
                        <td><b>'.$this->name($arr["segunda"]['manha'][$x][0]).'</b></td>
                        <td>'.$arr["segunda"]['manha'][$x][1].'</td>
                        <td>'.$arr["terca"]['manha'][$x][1].'</td>
                        <td>'.$arr["quarta"]['manha'][$x][1].'</td>
                        <td>'.$arr["quinta"]['manha'][$x][1].'</td>
                        <td>'.$arr["sexta"]['manha'][$x][1].'</td>
                    </tr>    
                ';
            }
            $html .= 
            '<tr class="info">
                <td colspan="6" style="text-align:center"><b>Tarde<b></td>
            </tr>';
            for($x = 0;$x< $this->bolsista->getNumBolsista('T'); $x++){
                $html = $html . '
                    <tr>
                        <td><b>'.$this->name($arr["segunda"]['tarde'][$x][0]).'</b></td>
                        <td>'.$arr["segunda"]['tarde'][$x][1].'</td>
                        <td>'.$arr["terca"]['tarde'][$x][1].'</td>
                        <td>'.$arr["quarta"]['tarde'][$x][1].'</td>
                        <td>'.$arr["quinta"]['tarde'][$x][1].'</td>
                        <td>'.$arr["sexta"]['tarde'][$x][1].'</td>
                    </tr>    
                ';
            }
            $html .= 
            '<tr class="danger">
                <td colspan="6" style="text-align:center"><b>Noite<b></td>
            </tr>';
            for($x = 0;$x< $this->bolsista->getNumBolsista('N'); $x++){
                $html = $html . '
                    <tr>
                        <td><b>'.$this->name($arr["segunda"]['noite'][$x][0]).'</b></td>
                        <td>'.$arr["segunda"]['noite'][$x][1].'</td>
                        <td>'.$arr["terca"]['noite'][$x][1].'</td>
                        <td>'.$arr["quarta"]['noite'][$x][1].'</td>
                        <td>'.$arr["quinta"]['noite'][$x][1].'</td>
                        <td>'.$arr["sexta"]['noite'][$x][1].'</td>
                    </tr>    
                ';
            }
            return $html;
        }
        public function getLastId(){
            $id = mysqli_query($this->conn, "select max(id) from escalas");
            while($row = mysqli_fetch_array($id)){
                $true = $row['max(id)'];
            }
            return $true;
        }
    }
?>