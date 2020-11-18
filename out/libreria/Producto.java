package libreria;

	/** Clase abastracta que representa un <b>producto</b> genérico para una tienda online.
	 *  <p>Los objetos de esta clase contienen atributos que permiten almacenar la mínima información
	 *  necesaria de un producto para ser comercializado en la tienda:</p>
	 *  <ul> 
	 *  <li><b>Nombre</b> del producto.</li>
	 *  <li><b>Precio</b> del producto (valor real en el rango 0.01-10000.00 euros).</li>
	 *  <li><b>Descripción</b> del producto.</li>
	 *  </ul>
	*/
public abstract class Producto implements Arrayable{



	/** Mínimo precio permitido.*/
	public static final double MIN_PRECIO;

	/** Máximo precio permitido.*/
	public static final double MAX_PRECIO;

	/** Nombre del producto*/
	protected String nombre;

	/** Descripción del producto.*/
	protected String descripcion;

	/** Precio del producto.*/
	protected double precio;

	//Constructores
	/** Crea un objeto <code>Producto</code> con un <b>nombre</b>, 
	 *  un <b>precio</b> y un <b>texto de descripción</b>.

	 * @param nombre Nombre del producto	 * @param precio Precio del producto	 * @param descripcion Descripción del producto. 	 * @throws IllegalArgumentException si alguno de los parámetros no es válido
	*/
	public Producto(String nombre, double precio, String descripcion) throws IllegalArgumentException{
	}


	//Métodos
	/** Devuelve el <b>nombre</b> del producto
	* @return Nombre del producto
	*/
	public String getNombre(){
		return this.nombre;
	}

	/** Devuelve la <b>descripción</b> del producto
	* @return Descripción del producto
	*/
	public String getDescripcion(){
		return this.descripcion;
	}

	/** Devuelve el <b>precio</b> actual del producto
	* @return precio del producto
	*/
	public double getPrecio(){
		return this.precio;
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