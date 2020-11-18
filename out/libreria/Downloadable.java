package libreria;

	/** Interfaz que incorpora la capacidad de ser descargado de la red.
	*/
public interface Downloadable{


	//Métodos
	/** Descarga el elemento por la red.
	 *  @param anchoBanda ancho de banda del sistema (en Kb/seg)	 * @return tiempo necesario para descargar el elemento (en segundos) 	 * @throws IllegalArgumentException si el ancho de banda no es mayor que cero
	*/
	public abstract double descargar(double anchoBanda) throws IllegalArgumentException;


}