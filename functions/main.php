<?php
$errores = 0;
/**
* Función para borrar directorio
* @ $dir Directorio a borrar
**/
function deleteDirectory($dir) {
	if (!file_exists($dir)) {
		return true;
	}

	if (!is_dir($dir)) {
		return unlink($dir);
	}

	foreach (scandir($dir) as $item) {
		if ($item == '.' || $item == '..') {
			continue;
		}

		if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
			return false;
		}

	}

	return rmdir($dir);
}

function buscar($buscar,$reemplazar,$contenido){
	if(preg_match("/$buscar/", $contenido, $coincidencias, PREG_OFFSET_CAPTURE)){
		return preg_replace("/$buscar/", $reemplazar, $coincidencias[1][0]);}
		else{
			return "";
		}
	}

/**
* Funcion que devuelve los directorios a crear
* @$directorio Directorio del javaDoc
**/	
function obtenerEstructura($directorio){
	global $errores;
	$constructorPadre;
	$directorio = str_replace("\\","/",$directorio);
	$directorio = str_replace("file:///", "", $directorio);
	$directorio = str_replace("%20", " ", $directorio);
	$directorio = explode("javadoc", $directorio);
	if($directorio[0]){$directorio = $directorio[0]."javadoc";}
	if(file_exists($directorio."/overview-tree.html")){
		$root = "../out";
		gc_collect_cycles();
		deleteDirectory($root);
		mkdir($root);
		// Creamos un instancia de la clase ZipArchive
		$zip = new ZipArchive();
		// Creamos y abrimos un archivo zip temporal
		$zip->open("$root/codigo.zip",ZipArchive::CREATE);
		//obtener codigo del fichero
		$contenido = file_get_contents($directorio."/overview-tree.html");
		$buscar = '/<li type="circle">([a-zA-Z0-1.\-]+).<a href="[a-zA-Z.\/]+" title="(class|interface) in [a-zA-Z0-1.\-_]+"><span class="[a-zA-Z]+">([A-Za-z]+)<\/span><\/a>( \(implements [a-zA-Z\s]+.<a href="[a-zA-Z\/.]+" title="(\w|\s)+">[A-Za-z0-1_-]+)?/';
		preg_match_all($buscar, $contenido, $coincidencias, PREG_OFFSET_CAPTURE);
		//Obtener la estructura
		for ($i=0; $i < count($coincidencias[0]); $i++) { 
			$aanalizar = $coincidencias[0][$i][0];
			$paquete = buscar('([a-zA-Z0-9.]+).<a href="',"$1",$aanalizar);
			$java = buscar('([a-zA-Z0-9]+).html',"$1",$aanalizar);
			$type = buscar('title="(class|interface) in ',"$1",$aanalizar);
			$enlace = buscar($paquete.'.<a href="([a-zA-Z\/\._\-0-1]+)" title="'.$type,"$1",$aanalizar);
			if(file_exists($directorio."/".$enlace)){
			//Obtiene si implementa una interfaz
				$interfaz = buscar('title="interface in [A-Za-z0-9]+">([A-Za-z0-9]+)',"$1",$aanalizar);
				$ini = "";

			## BUSCAMOS EN EL JAVADOC DE CADA ARCHIVO
				$interfaz = !empty($interfaz) ? " implements ".$interfaz : $errores++;
			//Obtener contenido del fichero .java
				$javaContenido = file_get_contents($directorio."/".$enlace);
				$buscarTipo = '/<div class="description">[a-zA-Z\s\n<>=":\/\.,]+<pre>[a-zA-Z\s<>="\/\.áéíóúÁÉÍÓÚñÑ\(\),:]+<\/pre>/';
				preg_match_all($buscarTipo, $javaContenido, $javaCoincidencias, PREG_OFFSET_CAPTURE);
			//Obtener cabecera inicial del archivo
				preg_match('/<pre>[a-zA-Z\s<>="\/\.áéíóúÁÉÍÓÚñÑ\(\),:]+<\/pre>/', $javaCoincidencias[0][0][0], $javaCoincidenciasII, PREG_OFFSET_CAPTURE);
			//Quitamos saltos de lineas
				$ini = saltosToEspacio(strip_tags($javaCoincidenciasII[0][0]));
			//Omitimos esto del main
				$ini = str_replace(" extends java.lang.Object", "",$ini);
				$ini = str_replace(", java.io.Serializable", "",$ini);
				comprobarError($ini);

			## BUSCAMOS EL COMENTARIO DEL ARCHIVO
				$comentario = "";
				$comentarioJava = "";
			//Estructura grande
				if(preg_match_all('/<div class="description">[a-zA-Z\s\n<>=":\/\.,]+<pre>[a-zA-Z\s<>="\/\.áéíóúÁÉÍÓÚñÑ\(\),:]+<\/pre>[\r\n|\n|\r]+<div class="block">[a-zA-Z0-9\s<>\/áéíóúÁÉÍÓÚñÑ.(),:-]+<\/div>([\r\n|\n|\r]+<dl)?/', $javaContenido, $comentarioI, PREG_OFFSET_CAPTURE)){
			//Obtener comentarios
					$comentarioJava = preg_match('/<div class="block">[a-zA-Z0-9\s<>\/áéíóúÁÉÍÓÚñÑ.(),:\-]+<\/div>[\r\n|\n|\r]+(<\/l|<dl)/', $comentarioI[0][0][0], $comentario, PREG_OFFSET_CAPTURE);
			//Quitamos el div
					$comentario = substr(comentario($comentario[0][0]),0,-4);
				}
				$comentarioJava = $comentario ? "\n\t/**\n".$comentario."*/" : "";


			## ATRIBUTOS
				$atributoss = "";
			//Estructura grande
				if(preg_match_all('/<!-- ============ FIELD DETAIL =========== -->[a-zA-Z0-9\-_\n<>\s=".!\/&;áéíóúÁÉÍÓÚÑñ:#\(\)]+<!-- =+\s[MC]/', $javaContenido, $atributosI, PREG_OFFSET_CAPTURE)){
					//Tipo del stributo	
					if(preg_match_all('/<pre>[a-zA-Z0-9\s=".\-_\/&;áéíóúÁÉÍÓÚÑñ:#,]+<\/pre>/', $atributosI[0][0][0], $tipoA, PREG_OFFSET_CAPTURE)){
						//Nombre atributo
						preg_match_all('/<div class="block">[a-zA-Z0-9\s<>\/áéíóúÁÉÍÓÚñÑ.(),:-]+<\/div>/', $atributosI[0][0][0], $comentA, PREG_OFFSET_CAPTURE);
						$contador = count($tipoA[0]);
						$atributoss = obtenerAtributo($contador,$tipoA,$comentA);

					}
				}

			## CONSTRUCTORES
				$constructores = "";
				if(preg_match_all('/<!-- ========= CONSTRUCTOR DETAIL ======== -->[0-9a-zA-Z\s<>="-_.!áéíóúÁÉÍÓÚñÑ\n\r]+<!-- ============ METHOD DETAIL ========== -->/', $javaContenido, $constructoress, PREG_OFFSET_CAPTURE)){
					//Obtener estructura principal
					if(preg_match_all('/<pre>[0-9a-zA-Z\s\-&;\(\)_.!áéíóúÁÉÍÓÚñÑ\n\r,<>="\/]+<\/pre>/', $constructoress[0][0][0], $constructorI, PREG_OFFSET_CAPTURE)){
						//Obtener parametros en comentarios
						if(preg_match_all('/<dd>[0-9a-zA-ZáéíóúÁÉÍÓÚñÑ\n\r\s.<\/>"=:\-\(\)]+<\/dd>/', $constructoress[0][0][0], $comentParam, PREG_OFFSET_CAPTURE)){
							//cabecera comentario
							preg_match_all('/<div class="block">[0-9a-zA-Z\s\-&;\(\)_.!áéíóúÁÉÍÓÚñÑ\n\r,<>\/"]+<\/div>/', $constructoress[0][0][0], $ccabecera, PREG_OFFSET_CAPTURE);

							if(substr_count($comentParam[0][0][0],"a") > 0 || substr_count($comentParam[0][0][0],"e") > 0 || substr_count($comentParam[0][0][0],"i") > 0 || substr_count($comentParam[0][0][0],"o") > 0 || substr_count($comentParam[0][0][0],"u") > 0){
								$constructores = obtenerConstrucor($constructorI,$ccabecera,$comentParam,$ini);
							}
						}
					}
				}

			## Métodos
				$metodos = "";

				//Aislamos la estructura principal
				if(preg_match('/METHOD DETAIL ========== -->[a-zA-Z0-9\n<>\s=".!\-_\/,&;:()#áéíóúÁÉÍÓÚñÑ{}\[\]]+<!-- ========= END/', $javaContenido, $metodos, PREG_OFFSET_CAPTURE)){
					//Obtener el codigo del metodo
					if(preg_match_all('/<pre>[0-9a-zA-Z\s\-&;\(\)_.!áéíóúÁÉÍÓÚñÑ\n\r,="\/\[\]]+<\/pre>/', $metodos[0][0], $codeM, PREG_OFFSET_CAPTURE)){
						//Obtener parametros en comentarios
						preg_match_all('/<d[dt]>[0-9a-zA-ZáéíóúÁÉÍÓÚñÑ\n\r\s.<\/>"=:\-\(\){};,_]+<\/d[dt]>/', $metodos[0][0], $paramM, PREG_OFFSET_CAPTURE);
						//Cabecera
						preg_match_all('/<div class="block">[0-9a-zA-Z\s\-&;\(\)_.!áéíóúÁÉÍÓÚñÑ\n\r,<>\/"]+<\/div>/', $metodos[0][0], $ccabeceraM, PREG_OFFSET_CAPTURE);
						$metodos = obtenerMetodos($codeM,$ccabeceraM,$paramM);
						
					}
				}

			## CREACION DEL DIRECTORIO Y FICHERO
				$atributoss = !empty($atributoss) ? "\n\n$atributoss": "";
				$constructores = !empty($constructores) ? "$constructores": "";
				$mensaje ="package $paquete;\n$comentarioJava\n$ini{\n\n{$atributoss}{$constructores}\n$metodos\n}";
				$mensaje = preg_replace("/\/\*\*\s+\*/", "/**", $mensaje);
				$mensaje = preg_replace("/\s\*[\s]+\*/","*", $mensaje);
				$mensaje = preg_replace("/<strong>/","<b>", $mensaje);
				$mensaje = preg_replace("/<\/strong>/","</b>", $mensaje);

			//Crea el directorio si no existe
				if(!file_exists($root."/".$paquete)){
					mkdir($root."/".$paquete);
					$zip->addEmptyDir($paquete);
				}

			## CREAR ARCHIVO ##
				$nombre_archivo = $root."/".$paquete."/".$java.".java"; 
				if($archivo = fopen($nombre_archivo, 'w')){
					fwrite($archivo,$mensaje);
					fclose($archivo);
				}
				$zip->addFromString($paquete."/".$java.".java",$mensaje);
			}
		}$zip->close();
		echo "Código creado <a href=\"out/codigo.zip\" download>Descargar</a>";
	}else{
		echo "Error: JavaDoc no encontrado.";
	}
}

//combierte los saltos de linea en espacios
function saltosToEspacio($text){
	return preg_replace("/[\r\n|\n|\r]+/", " ", preg_replace("/&nbsp;/", " ", $text));
}

//Omitir tabulaciones
function quitTab($text){
	return preg_replace("/(\t{2,}|\s{2,})/", " ", $text);
}

//omitir java.lang.
function omitirJLang($resultado){
	$resultado = preg_replace("/java.lang./","",$resultado);
	$resultado = preg_replace("/java.util./","",$resultado);
	$resultado = preg_replace("/&lt;/","<",$resultado);
	$resultado = preg_replace("/&gt;/",">",$resultado);
	return $resultado;
}

function obtenerConstrucor($cons,$comentcabe,$comentparams,$ini){
	global $constructorPadre;
	$result = "";
	$contadorTotalConstrucotres = count($cons[0]);
	for ($i=0; $i < $contadorTotalConstrucotres; $i++) {
		//Cabecera comentario
		$result .= $i == 0 ? "\t//Constructores\n" : "";
		$result .= isset($comentcabe[0][$i][0]) ? "\t/**\n".comentario($comentcabe[0][$i][0])."\n" : "\t/**\n";
		//Parametros comentarios
		$result .= paramComent($comentparams[0][$i][0],$overides)."\n\t*/\n";
		//Eliminar <pre></pre>
		$construct = strip_tags(quitTab(saltosToEspacio(omitirJLang("\t".str_replace("</pre>", "", str_replace("<pre>", "", $cons[0][$i][0]))))));
		$argumentos = preg_replace("/([a-zA-Z\-_\[\]]+\s)/","",buscar("\(([a-zA-Z\-_\[\],\s]+)\)","$1",$construct));
		$constructorPadre["".buscar("([a-zA-Z]+)\(","$1",$construct).""] = "super(".$argumentos.");\n"; 
		//Salto si es segundo o mas
		$result .= $construct;
		$final ="{\n\t}\n\n";
		//Llamada al constructor padre
		if(substr_count($ini,"extends") > 0){
			$final = obtenerSuper($i,$contadorTotalConstrucotres,$ini,$argumentos);
		}
		$result .= $final;
	}
	return $result;
}

function obtenerSuper($iActual,$contFor,$ini,$argumentos){
	global $constructorPadre;
	$final ="{\n\t}\n\n";
	$super = buscar("extends ([a-zA-Z\-_.]+)","$1",$ini);
	if($constructorPadre[$super]){
		$argArray = explode(",",preg_replace("/\s+/","",$argumentos));
		$constructSuper = $constructorPadre[$super];
		$noEncontrado = 0;
		$thisn = 0;
		$thisVariable = "";
		$nuevosAtributos = "";
		for ($i=0; $i < count($argArray); $i++) { 
			if(substr_count($constructSuper,$argArray[$i]) == 0){
				if(($iActual+1) != $contFor){
					$noEncontrado++;
					$nuevosAtributos .= ", ".$argArray[$i];
				}else{
					$thisn++;
					$thisVariable .= "\t\tthis.".$argArray[$i]." = ".$argArray[$i].";\n";
				}
			}
		}
		if($noEncontrado > 0){$constructSuper = substr($constructSuper, 0, -3).$nuevosAtributos.");\n";}
		if($thisn > 0){$constructSuper = $constructSuper.$thisVariable;}
		if(($iActual+1) != $contFor){
			$constructSuper = preg_replace("/super/","this",$constructSuper);
		}
		$final = "{\n\t\t".$constructSuper."\t}\n\n";
	}
	return $final;
}

function obtenerMetodos($cons,$comentcabe,$comentparams){
	$result = "";
	$sumaP = 0;
	for ($i=0; $i < count($cons[0]); $i++) {
		//Cabecera comentario
		$result .= $i == 0 ? "\t//Métodos\n" : "";
		$result .= isset($comentcabe[0][$i][0]) ? "\t/**\n".comentario($comentcabe[0][$i][0])."\n" : "\t/**\n";
		//Parametros comentarios
		$overides=0;
		$overidest = 0;
		$countr = 0;
		//Comprobamos si hay @Override
		do{
			if(isset($comentparams[0][$i+$sumaP][0]) && substr_count($comentparams[0][$i+$sumaP][0],"override") > 0){
				$sumaP++;
				$overides++;
				$otraVez = true;
			}else{$otraVez = false;}
		}while($otraVez);
		if(isset($comentparams[0][$i+$sumaP]) && $comentparams[0][$i+$sumaP][0]){
			$result .= paramComent($comentparams[0][$i+$sumaP][0],$overidest)."\n\t*/\n";
		}else{$result .="\n\t*/\n";}
		$result .= $overides == 0 && $overidest == 0 ? "" : "\t@Override\n";
		//Eliminar <pre></pre>
		$method = strip_tags(quitTab(saltosToEspacio(str_replace("</pre>", "", str_replace("<pre>", "", $cons[0][$i][0]))))); 
		$final = "{\n\t\tthrow new Error();\n\t}";
		if(substr_count($method,"get") > 0){
			$returnn = buscar('get([a-zA-Z0-9_\-.]+)()', "$1", $method);
			$final = "{\n\t\treturn this.".lcfirst($returnn).";\n\t}";
		}
		if(substr_count($method,"public") == 0){
			$method = "public abstract ".$method;
			$final = ";";
		}
		//Salto si es segundo o mas
		$result .= "\t".omitirJLang($method);
		$result .= $final."\n\n";
	}
	return $result;
}

//Sumar si hay error
function comprobarError($valor){
	global $errores;
	if(empty($valor)){
		$errores++;
	}
}

//funcion que devuelve parametros en comentarios
function paramComent($string,&$overe){
	$result = "";
	$arraynw = explode("\n", $string);
	$parametros = 0;
	$Preturns = 0;
	$overe = 0;
	$parametrosTotales = 0;
	for ($i=0; $i < count($arraynw); $i++) {
		//pongo @param o @throws
		if(substr_count($arraynw[$i],"throwsLabel") == 0 && substr_count($arraynw[$i],"returnLabel") == 0 && substr_count($arraynw[$i],"paramLabel") == 0 && substr_count($arraynw[$i],"override") == 0){
			$arroba =  $parametros == 0 ? "@param": "@throws";
			$comenter = $parametrosTotales != 0 ? "\t * " : "";
			$reemp = preg_replace("/<dd><code>/", $comenter.$arroba." ", $arraynw[$i]);
			//Quito etiquetas
			$result .= omitirJLang(preg_replace("/(<[dl\/]+>|<\/code> -)/", "", $reemp));
			$parametrosTotales++;
		}else{
			//Borro si existe throws
			if(substr_count($arraynw[$i],"throwsLabel") > 0){$parametros++;}
			if(substr_count($arraynw[$i],"returnLabel") > 0){$Preturns++;}
			if(substr_count($arraynw[$i],"override") > 0){$overe++;}
			$delete0 = str_replace('<dt><span class="paramLabel">Parameters:</span></dt>', '', $arraynw[$i]);
			$deleteI = str_replace('<dt><span class="throwsLabel">Throws:</span></dt>', '', $delete0);
			$deleteII = str_replace('<dt><span class="overrideSpecifyLabel">Specified by:</span></dt>', '', $deleteI);
			$result .= str_replace('<dt><span class="returnLabel">Returns:</span></dt>', "\t * @return", saltosToEspacio($deleteII));

		}
	}
	return comentario(preg_replace("/[\r\n|\n|\r]{2,}/", "\n",$result));
}

//Funtion que devuelve un comentario
function comentario($texto){
	$resultado = "";
	$texto = str_replace("</div>", "", str_replace("<div class=\"block\">", "", $texto));
	$arraynw = explode("\n", $texto);
	for ($i=0; $i < count($arraynw); $i++) {
		$salto = count($arraynw) == 1 ? "" : "\n";
		$resultado .= "\t * ".$arraynw[$i].$salto;
	}
	return $resultado;
}

//Obtener tipoAtributo nombreAtributo;
function obtenerAtributo($nume,$tipoA,$comentA){
	$result = "";
	for ($i=0; $i < $nume; $i++) { 
		if($tipoA[0][$i][0]){
			$result .= isset($comentA[0][$i][0]) ? "\t/**".comentario($comentA[0][$i][0])."*/\n" : "";
			$result .= "\t".omitirJLang(strip_tags($tipoA[0][$i][0])).";\n\n";
		}
	}
	return preg_replace("/&nbsp;/", " ", $result);
}

if(isset($_GET["url"]) && !empty($_GET["url"])){obtenerEstructura($_GET["url"]);}
else{echo "Error: ¡URL vacía!";}