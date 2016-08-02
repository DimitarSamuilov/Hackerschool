package task_package;

import java.util.Scanner;

public class Multipliction {

	public static void main(String[] args) {
		Scanner input=new Scanner(System.in);
		System.out.println("Element?");
		int position=input.nextInt();
		String numbers=create();
		System.out.println(numbers.length());
		System.out.println(numbers.charAt(position));
	}
	public static String create(){
		long counter=0;
		StringBuilder tempStr=new StringBuilder();
		while (tempStr.length()< 3200000){
			tempStr.append(counter*counter);
			counter++;
		}
		
		
		return  tempStr.toString();
	}

}
