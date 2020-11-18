package libreria;

	/** Interfaz que incorpora la capacidad de obtener el contenido del objeto en forma de arrays.
	*/
public interface Arrayable{


	//Métodos
	/** Genera array de nombres de atributos.
	* @return array de <code>String</code> con los nombres de los atributos de la clase de  la cual el objeto es instancia
	*/
	public abstract String[] toArrayAtribNames();

	/** Genera array de valores de atributos.
	* @return array de <code>String</code> con los valores de los atributos del objeto
	*/
	public abstract String[] toArrayAtribValues();


}