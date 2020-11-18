package libreria;

	/** Clase que representa un <b>producto</b> de tipo <b>EReader</b> para la gestión de productos en una tienda.
	 *  <p>Los objetos de esta clase contienen atributos que permiten almacenar toda la
	 *  información relativa a un producto de tipo EReader (lector de libros electrónicos) 
	 *  en una tienda.
	 *  Además de los atributos propios de un producto, deberá contener los específicos 
	 *  de un EReader, que son:</p>
	 *  <ul>
	 *  <li><b>Fabricante</b> del EReader (Amazon, BQ, Sony, Onyx, ICARUS, etc.).</li>
	 *  </ul>
	*/
public class EReader extends Producto{

	//Constructores
	/** Crea un objeto ERreader con un nombre, precio, texto de descripción y fabricante.
	 * @param nombre Nombre del dispostivo	 * @param precio Precio del dispostivo	 * @param descripcion Descripción del dispostivo	 * @param fabricante fabricante del dispostivo 	 * @throws IllegalArgumentException si alguno de los parámetros no es válido
	*/
	public EReader(String nombre, double precio, String descripcion, String fabricante) throws IllegalArgumentException{
		super(nombre, precio, descripcion);
		this.fabricante = fabricante;
	}


	//Métodos
	/** Devuelve el nombre del <b>fabricante</b> del dispositivo
	* @return descripción del producto
	*/
	public String getFabricante(){
		return this.fabricante;
	}

	/** Genera array de nombres de atributos.
	* @return array de <code>String</code> con los nombres de los atributos de la clase de  la cual el objeto es instancia
	*/
	@Override
	public String[] toArrayAtribNames(){
		throw new Error();
	}

	/** Genera array de valores de atributos.
	* @return array de <code>String</code> con los valores de los atributos del objeto
	*/
	@Override
	public String[] toArrayAtribValues(){
		throw new Error();
	}


}