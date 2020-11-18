package libreria;

	/** Clase abstracta que representa un <b>producto</b> de tipo <b>Libro</b> para la gestión de productos en una tienda.
	 *  <p>Los objetos de esta clase contienen atributos que permiten almacenar la
	 *  información relativa a un producto de tipo Libro en una tienda.
	 *  Además de los atributos propios de un producto, deberá contener los específicos 
	 *  de un libro, que son:</p>
	 *  <ul>
	 *  <li><b>Autor</b> del libro.</li>
	 *  <li><b>Año de edición</b> del libro.</li>
	 *  </ul>
	 *  <p>Se trata de una clase abastracta que contiene la información mínima sobre el libro
	 *  pero no contiene información que depende de su formato físico (si se trata de un libro en papel
	 *  o un libro electrónico). Para eso existen otras clases especializadas que heredarán
	 *  de ésta.</p>
	*/
public abstract class Libro extends Producto{



	/** Mínimo año de edición permitido.*/
	public static final int MIN_YEAR;

	/** <b>Autor</b> del libro*/
	protected String autor;

	/** <b>Año de edición</b> del libro*/
	protected int year;

	//Constructores
	/** Crea un objeto Libro con un nombre, precio, un texto de descripción y autor.
	 * @param nombre Título del libro	 * @param precio Precio del libro	 * @param descripcion Descripción del libro	 * @param autor Autor del libro	 * @param year Año de edición del libro 	 * @throws IllegalArgumentException si alguno de los parámetros no es válido
	*/
	public Libro(String nombre, double precio, String descripcion, String autor, int year) throws IllegalArgumentException{
		super(nombre, precio, descripcion);
		this.autor = autor;
		this.year = year;
	}


	//Métodos
	/** Devuelve el nombre del <b>autor</b> del libro
	* @return autor
	*/
	public String getAutor(){
		return this.autor;
	}

	/** Devuelve el <b>año de publicación</b> del libro
	* @return año de publicación
	*/
	public int getYear(){
		return this.year;
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