
/**
 * SortingAlgorithms.java
 *
 * Muestra las implementaciones en Java de cinco algoritmos de ordenación
 * comunes: Bubble Sort, Insertion Sort, Selection Sort, Merge Sort y Quick Sort.
 *
 * El objetivo de esta clase es mostrar la lógica básica de cada algoritmo.
 * Las complejidades temporales son:
 * - O(n^2): Bubble Sort, Insertion Sort y Selection Sort
 * - O(n log n): Merge Sort y Quick Sort (en promedio)
 */
public class OrdenazioAlgoritmoak {

    // Función auxiliar: intercambia dos elementos de un array.
    private static void swap(int[] array, int i, int j) {
        int temp = array[i];
        array[i] = array[j];
        array[j] = temp;
    }

    /**
     * 1. Ordenación por Burbuja (Bubble Sort)
     * Complejidad: O(n^2)
     *
     * Compara los elementos de dos en dos y los intercambia si están
     * en el orden incorrecto. Los elementos más grandes van
     * desplazándose hacia el final del array.
     */
    public static void bubbleSort(int[] array) {
        int n = array.length;
        for (int i = 0; i < n - 1; i++) {
            // Se excluye la parte del array que ya está ordenada.
            for (int j = 0; j < n - i - 1; j++) {
                if (array[j] > array[j + 1]) {
                    // Intercambiar array[j] y array[j+1].
                    swap(array, j, j + 1);
                }
            }
        }
    }

    /**
     * 2. Ordenación por Inserción (Insertion Sort)
     * Complejidad: O(n^2)
     *
     * Divide el array en una parte ordenada y otra sin ordenar.
     * Toma un elemento de la parte sin ordenar y lo inserta
     * en su posición correcta dentro de la parte ordenada.
     */
    public static void insertionSort(int[] array) {
        int n = array.length;
        for (int i = 1; i < n; ++i) {
            int key = array[i];
            int j = i - 1;

            /*
             * Desplazar una posición hacia la derecha los elementos
             * de array[0...i-1] que sean mayores que "key",
             * para dejar espacio e insertar el elemento.
             */
            while (j >= 0 && array[j] > key) {
                array[j + 1] = array[j];
                j = j - 1;
            }
            array[j + 1] = key;
        }
    }

    /**
     * 3. Ordenación por Selección (Selection Sort)
     * Complejidad: O(n^2)
     *
     * Recorre el array para encontrar el elemento más pequeño
     * de la parte sin ordenar y lo intercambia con el elemento
     * situado al principio de esa parte.
     */
    public static void selectionSort(int[] array) {
        int n = array.length;
        for (int i = 0; i < n - 1; i++) {
            // Encontrar el elemento más pequeño de la parte sin ordenar.
            int min_idx = i;
            for (int j = i + 1; j < n; j++) {
                if (array[j] < array[min_idx]) {
                    min_idx = j;
                }
            }

            // Intercambiar el elemento más pequeño con el primero.
            swap(array, min_idx, i);
        }
    }

    // --- Implementación de Merge Sort ---

    /**
     * 4. Función de Fusión (Merge)
     *
     * Combina dos subarrays ordenados (array[l..m] y
     * array[m+1..r]) en un único array ordenado.
     */
    private static void merge(int[] array, int l, int m, int r) {
        // Crear arrays temporales.
        int n1 = m - l + 1;
        int n2 = r - m;

        int[] L = new int[n1];
        int[] R = new int[n2];

        // Copiar los datos a los arrays temporales.
        for (int i = 0; i < n1; ++i)
            L[i] = array[l + i];
        for (int j = 0; j < n2; ++j)
            R[j] = array[m + 1 + j];

        // Proceso de fusión de los dos subarrays.
        int i = 0, j = 0; // Índices iniciales de los subarrays L y R.
        int k = l;        // Índice inicial de la parte que se va a fusionar.

        while (i < n1 && j < n2) {
            if (L[i] <= R[j]) {
                array[k] = L[i];
                i++;
            } else {
                array[k] = R[j];
                j++;
            }
            k++;
        }

        // Copiar los elementos restantes de L, si los hay.
        while (i < n1) {
            array[k] = L[i];
            i++;
            k++;
        }

        // Copiar los elementos restantes de R, si los hay.
        while (j < n2) {
            array[k] = R[j];
            j++;
            k++;
        }
    }

    /**
     * 4. Ordenación por Fusión (Merge Sort)
     * Complejidad: O(n log n)
     *
     * Parámetros:
     * - array: array que se va a ordenar.
     * - l: índice izquierdo.
     * - r: índice derecho.
     *
     * Divide el array en dos mitades, ordena cada mitad
     * de forma recursiva y después las fusiona.
     */
    public static void mergeSort(int[] array, int l, int r) {
        if (l < r) {
            // Encontrar el punto medio del array.
            int m = l + (r - l) / 2;

            // Ordenar la primera y la segunda mitad.
            mergeSort(array, l, m);
            mergeSort(array, m + 1, r);

            // Fusionar las dos mitades ordenadas.
            merge(array, l, m, r);
        }
    }

    // --- Implementación de Quick Sort ---

    /**
     * 5. Función de Partición (para Quick Sort)
     *
     * Coloca el pivote en su posición correcta dentro del array.
     * Los elementos menores o iguales que el pivote quedan
     * a su izquierda y los mayores quedan a su derecha.
     *
     * Devuelve el índice donde queda situado el pivote.
     */
    private static int partition(int[] array, int low, int high) {
        // Elegir el último elemento como pivote.
        int pivot = array[high];
        int i = (low - 1); // Índice de los elementos menores o iguales al pivote.

        for (int j = low; j < high; j++) {
            // Si el elemento actual es menor o igual que el pivote.
            if (array[j] <= pivot) {
                i++;
                // Intercambiar array[i] y array[j].
                swap(array, i, j);
            }
        }

        // Intercambiar el pivote con array[i+1].
        swap(array, i + 1, high);

        return i + 1;
    }

    /**
     * 5. Función Recursiva de Quick Sort
     * Complejidad:
     * - Caso promedio: O(n log n)
     * - Peor caso: O(n^2)
     *
     * Ordena el array dividiéndolo alrededor de un pivote
     * y aplicando el mismo proceso de forma recursiva.
     */
    public static void quickSort(int[] array, int low, int high) {
        if (low < high) {
            // pi es el índice de partición; el pivote ya está en su posición correcta.
            int pi = partition(array, low, high);

            // Ordenar los elementos anteriores y posteriores al pivote.
            quickSort(array, low, pi - 1);
            quickSort(array, pi + 1, high);
        }
    }

    /**
     * Función auxiliar para imprimir los elementos de un array.
     */
    private static void printArray(int[] array) {
        for (int i = 0; i < array.length; i++) {
            System.out.print(array[i] + " ");
        }
        System.out.println();
    }

    // Programa principal para probar los algoritmos.
    public static void main(String[] args) {
        // Datos de prueba para cada algoritmo.
        int[] dataBubble = {64, 34, 25, 12, 22, 11, 90};
        int[] dataInsertion = {12, 11, 13, 5, 6};
        int[] dataSelection = {64, 25, 12, 22, 11};
        int[] dataMerge = {38, 27, 43, 3, 9, 82, 10};
        int[] dataQuick = {10, 80, 30, 90, 40, 50, 70};

        System.out.println("--- Ejemplos de Algoritmos de Ordenación (Java) ---");

        // 1. Ordenación por Burbuja.
        System.out.println("\n1. Ordenación por Burbuja (Bubble Sort)");
        System.out.print("Original: ");
        printArray(dataBubble);
        bubbleSort(dataBubble);
        System.out.print("Ordenado: ");
        printArray(dataBubble);

        // 2. Ordenación por Inserción.
        System.out.println("\n2. Ordenación por Inserción (Insertion Sort)");
        System.out.print("Original: ");
        printArray(dataInsertion);
        insertionSort(dataInsertion);
        System.out.print("Ordenado: ");
        printArray(dataInsertion);

        // 3. Ordenación por Selección.
        System.out.println("\n3. Ordenación por Selección (Selection Sort)");
        System.out.print("Original: ");
        printArray(dataSelection);
        selectionSort(dataSelection);
        System.out.print("Ordenado: ");
        printArray(dataSelection);

        // 4. Ordenación por Fusión.
        System.out.println("\n4. Ordenación por Fusión (Merge Sort)");
        System.out.print("Original: ");
        printArray(dataMerge);
        mergeSort(dataMerge, 0, dataMerge.length - 1);
        System.out.print("Ordenado: ");
        printArray(dataMerge);

        // 5. Ordenación Rápida.
        System.out.println("\n5. Ordenación Rápida (Quick Sort)");
        System.out.print("Original: ");
        printArray(dataQuick);
        quickSort(dataQuick, 0, dataQuick.length - 1);
        System.out.print("Ordenado: ");
        printArray(dataQuick);
    }
}
