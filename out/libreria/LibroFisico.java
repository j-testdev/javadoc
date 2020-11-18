package libreria;

	/** Clase que representa un <b>producto</b> de tipo <b>Libro Físico</b> para la gestión de productos en una tienda.
	 *  <p>Los objetos de esta clase contienen atributos que permiten almacenar toda la
	 *  información relativa a un producto de tipo libro físico (no electrónico) 
	 *  en una tienda.
	 *  Además de los atributos propios de un libro en abstracto, deberá contener los específicos 
	 *  de un libro físico, que son:</p>
	 *  <ul>
	 *  <li><b>Número de páginas</b> del libro.</li>
	 *  </ul>
	*/
public class LibroFisico extends Libro{



	/** Mínimo número de páginas permitido.*/
	public static final int MIN_PAGINAS;

	/** Máximo número de páginas permitido.*/
	public static final int MAX_PAGINAS;

	//Constructores
	/** Crea un objeto LibroFisico con un nombre, precio, texto de descripción, autor, año de edición y número de páginas.
	 * @param nombre Título del libro	 * @param precio Precio del libro	 * @param descripcion Descripción del libro	 * @param autor Autor del libro	 * @param year Año de edición del libro	 * @param numPaginas Número de páginas del libro 	 * @throws IllegalArgumentException si alguno de los parámetros no es válido
	*/
	public LibroFisico(String nombre, double precio, String descripcion, String autor, int year, int numPaginas) throws IllegalArgumentException{
		super(nombre, precio, descripcion, autor, year);
		this.numPaginas = numPaginas;
	}


	//Métodos
	/** Devuelve el <b>número de páginas</b> del libro
	* @return número depáginas del libro
	*/
	public int getNumPaginas(){
		return this.numPaginas;
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