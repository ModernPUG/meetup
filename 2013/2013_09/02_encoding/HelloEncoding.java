public class HelloEncoding {
    public static void main(String[] args) {
        byte [] eucStr = {(byte)176, (byte)161};
	try {
	    String str1 = new String(eucStr, "EUC-KR");
	    System.out.println(str1);
	    System.out.println((int)str1.charAt(0));
	        
	    String str2 = new String(eucStr, "UTF-8");
	    System.out.println(str2);
	    System.out.println((int)str2.charAt(0));
	        
	    String str3 = new String(str2.getBytes("UTF-8"), "EUC-KR");
            System.out.println(str3);
	} catch (Exception e) {}
    }
}
