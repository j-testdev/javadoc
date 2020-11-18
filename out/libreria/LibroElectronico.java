package libreria;

	/** Clase que representa un <b>producto</b> de tipo <b>Libro Electrónico</b> para la gestión de productos en una tienda.
	 *  <p>Los objetos de esta clase contienen atributos que permiten almacenar toda la
	 *  información relativa a un producto de tipo libro electrónico (ebook) 
	 *  en una tienda online.
	 *  Además de los atributos propios de un libro en abstracto, deberá contener los específicos 
	 *  de un libro electrónico, que son:</p>
	 *  <ul>
	 *  <li><b>Tamaño del archivo</b> (en kilobytes).</li>
	 *  <li><b>Número de veces</b> que se ha descargado el archivo.</li>
	 *  </ul>
	*/
public class LibroElectronico extends Libro implements Downloadable{



	/** Mínimo tamaño de archivo permitido.*/
	public static final int MIN_SIZE;

	/** Máximo tamaño de archivo permitido.*/
	public static final int MAX_SIZE;

	//Constructores
	/** Crea un objeto LibroElectronico con un nombre, precio, texto de descripción, autor, año de edición y tamaño en Kbytes.
	 * @param nombre Título del libro
	*/
	public LibroElectronico(String nombre, double precio, String descripcion, String autor, int year, int size) throws IllegalArgumentException{
		super(nombre, precio, descripcion, autor, year);
		this.size = size;
	}


	//Métodos
	/** Devuelve el <b>tamaño</b> en Kb del archivo EBook
	* @return Tamaño en Kb del EBook
	*/
	public int getSize(){
		return this.size;
	}

	/** Devuelve el <b>número de descargas</b> del archivo EBook hasta el momento
	* @return número de descargas del archivo EBook hasta el momento
	*/
	public int getNumDescargas(){
		return this.numDescargas;
	}

	/** Descarga el elemento por la red.
	 *  @param anchoBanda ancho de banda del sistema (en Kb/seg)
	*/
	@Override
	public double descargar(double anchoBanda) throws IllegalArgumentException{
		throw new Error();
	}

	/** Genera array de nombres de atributos.
	* @return array de <code>String</code> con los nombres de los atributos de la clase de 
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