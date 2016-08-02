package packageHouse;

public class Wharehouse {

	public static void main(String[] args) {

		int countFreeRow = 0;
		int countFreeCol = 0;
		int row = 0, col = 0;
		int[][] table = new int[][] { 
			{ 1, 1, 1, 0, 1, 0 }, 
			{ 0, 0, 0, 1, 0, 0 }, 
			{ 0, 1, 1, 0, 0, 0 },
			{ 1, 1, 0, 0, 1, 0 }, 
			{ 0, 0, 0, 0, 0, 0 }, 
			{ 1, 1, 1, 1, 1, 0 }, };

		int n = table.length - 1;
		int freeRow = 0;
		int freeCol = 0;
		for (row = 0; row <= n; row++) {
			for (col = 0; col <= n; col++) {
				if(table[col][row]==0){
					freeRow++;
				}
				if (table[row][col] == 0) {
					freeCol++;
				}
			}
			if(freeRow==n+1){
				countFreeRow++;
			}
			if (freeCol == n + 1) {
				countFreeCol++;
			}
			freeCol = 0;
			freeRow=0;

		}

		int left = 0;
		int bot = 0;
		col = 0;
		row = 0;
		int stoki = 0;
		for (row = 0; row <= n; row++) {
			for (col = 0; col <= n; col++) {

				if (table[row][col] == 1) {

					if (row + 1 <= n) {

						if (table[row + 1][col] == 0) {
							bot++;
						}
					} else
						bot++;
				}
				if (col + 1 <= n) {

					if (table[row][col + 1] == 0) {
						left++;
					}
				} else
					left++;

				if (bot + left == 2) {
					stoki++;

				}
				left = 0;
				bot = 0;
			}
			System.out.println();

		}
		for (row = 0; row <= n; row++) {
			for (col = 0; col <= n; col++) {
				System.out.printf("%d", table[row][col]);
			}
			System.out.println();
		}
		System.out.println("stoki:" + stoki);
		System.out.println("FreeRow:" + (countFreeCol + countFreeRow));
	}

}
