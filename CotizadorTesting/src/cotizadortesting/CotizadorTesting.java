/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package cotizadortesting;

import java.util.ArrayList;
import java.util.List;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.support.ui.Select;

/**
 *
 * @author LENOVO
 */
public class CotizadorTesting {

    public static void main(String[] args) throws InterruptedException {
        WebDriver driver = new ChromeDriver();
        registerPage(driver);
        testOrder(driver);
        testProductSelection(driver);
        testCurtainForm(driver);
        seeProducts(driver);
        editOrder(driver);
        addDataForSending(driver);
        deleteProduct(driver);
        deleteOrder(driver);
        //driver.close();
    }
    
    //Clase que procesa la busqueda y regresa una lista de elementos
    static void registerPage(WebDriver driver) throws InterruptedException{
        //Opcion a ingresar en el buscador
        driver.get("http://127.0.0.1:8000/");
        List<String> urls = new ArrayList<>();
        //Nombre del search field
        List<WebElement> links = driver.findElements(By.tagName("a"));
        //Recorre la lista de elementos
        for (WebElement link1 : links){
            //Obtiene el link
            String url = link1.getAttribute("href");
            if (url.contains("register")){
                link1.click();
                Thread.sleep(1000);
                String currentUrl = driver.getCurrentUrl();
                if (currentUrl.contains("register")){
                    System.out.println("Existe una pagina de registro y funciona");
                    testRegisterValidation(driver);
                    fillRegisterForm(driver);
                    break;
                } else {
                    System.out.println("No hay página de registro");
                }
            }
        }
    }
    
    //Funcion que hace un print dependiendo si es o no la primera opcion
    static void fillRegisterForm(WebDriver driver){
        try {
            WebElement name = driver.findElement(By.name("name"));
            WebElement email = driver.findElement(By.name("email"));
            WebElement password = driver.findElement(By.name("password"));
            WebElement password_confirmation = driver.findElement(By.name("password_confirmation"));
            name.sendKeys("TestName");
            email.sendKeys("test@mail.com");
            password.sendKeys("testing123");
            password_confirmation.sendKeys("testing123");
            WebElement button =  driver.findElement(By.id("signup"));
            button.submit();
            System.out.println("Registro correcto\n");
        } catch(org.openqa.selenium.NoSuchElementException e) {
            System.out.println("Formulario de registro incompleto\n");
        }
        
    }
    
    static void testRegisterValidation(WebDriver driver) throws InterruptedException{
        try {
            WebElement name = driver.findElement(By.name("name"));
            WebElement email = driver.findElement(By.name("email"));
            WebElement password = driver.findElement(By.name("password"));
            WebElement password_confirmation = driver.findElement(By.name("password_confirmation"));
            name.sendKeys("TestName");
            email.sendKeys("testemail");
            password.sendKeys("testing1234");
            password_confirmation.sendKeys("testing123");
            WebElement button =  driver.findElement(By.id("signup"));
            button.submit();
            Thread.sleep(1000);
            if(driver.getCurrentUrl().contains("register")) {
                System.out.println("Validación funcionando correctamente");
                name = driver.findElement(By.name("name"));
                email = driver.findElement(By.name("email"));
                Thread.sleep(1000);
                name.clear();
                email.clear();
            } else {
                System.out.println("Validación no funciona");
            }
        } catch(org.openqa.selenium.NoSuchElementException e) {
            System.out.println("Formulario de registro incompleto");
        }
        
    }
    
    static void testOrder(WebDriver driver) throws InterruptedException{
        //Opcion a ingresar en el buscador
        driver.get("http://127.0.0.1:8000/");
        List<String> urls = new ArrayList<>();
        //Nombre del search field
        List<WebElement> links = driver.findElements(By.tagName("a"));
        //Recorre la lista de elementos
        for (WebElement link1 : links){
            //Obtiene el link
            String url = link1.getAttribute("href");
            if (url.contains("/orders/new")){
                link1.click();
                Thread.sleep(1000);
                String currentUrl = driver.getCurrentUrl();
                if (currentUrl.contains("orders/new")){
                    System.out.println("Pagina para crear orden existe");
                    testOrderValidation(driver);
                    Thread.sleep(1000);
                    fillOrderForm(driver);
                    break;
                } else {
                    System.out.println("Página no existe");
                }
            }
        }
    }
    
    static void fillOrderForm(WebDriver driver){
        try {
            Select activity = new Select(driver.findElement(By.name("activity")));
            activity.selectByVisibleText("Oferta");
            WebElement button =  driver.findElement(By.id("create_order"));
            button.submit();
            System.out.println("Orden creada correctamente\n");
        } catch(org.openqa.selenium.NoSuchElementException e) {
            System.out.println("Formulario de creacion de orden incompleto\n");
        }
    }
    
    static void testOrderValidation(WebDriver driver){
        try {
            WebElement project = driver.findElement(By.name("project"));
            WebElement discount = driver.findElement(By.name("discount"));
            WebElement comments = driver.findElement(By.name("comments"));
            project.sendKeys("ProjectTesting");
            discount.sendKeys("0");
            comments.sendKeys("This is a test");
            WebElement button =  driver.findElement(By.id("create_order"));
            button.submit();
            if(driver.getCurrentUrl().contains("/orders/new")) {
                System.out.println("Validación funcionando correctamente");
            } else {
                System.out.println("Validación no funciona");
            }
        } catch(org.openqa.selenium.NoSuchElementException e) {
            System.out.println("Formulario de creacion de orden incompleto");
        }
    }
    
    static void testProductSelection(WebDriver driver){
        try {
            testProductValidation(driver);
            Select type = new Select(driver.findElement(By.name("type_id")));
            type.selectByVisibleText("Cortina");
            WebElement button = driver.findElement(By.id("select_product"));
            button.submit();
            System.out.println("Producto seleccionado correctamente\n");
        } catch(org.openqa.selenium.NoSuchElementException e) {
            System.out.println("Formulario de seleccion de producto incompleto\n");
        }
    }
    
    static void testProductValidation(WebDriver driver){
        try {
            Select type = new Select(driver.findElement(By.name("type_id")));
            type.selectByVisibleText("Palillerías");
            WebElement button = driver.findElement(By.id("select_product"));
            button.submit();
            if(driver.getCurrentUrl().contains("/orders/type")) {
                System.out.println("Validación funcionando correctamente");
            } else {
                System.out.println("Validación no funciona");
            }
        } catch(org.openqa.selenium.NoSuchElementException e) {
            System.out.println("Formulario de seleccion de producto incompleto\n");
        }
    }
    
    static void testCurtainForm(WebDriver driver) throws InterruptedException{
        try {
            testCurtainValidation(driver);
            Thread.sleep(1000);
            testCurtainDetails(driver);
            WebElement width = driver.findElement(By.name("width"));
            WebElement height = driver.findElement(By.name("height"));
            WebElement quantity = driver.findElement(By.name("quantity"));
            width.sendKeys("4");
            height.sendKeys("2.5");
            quantity.sendKeys("1");
            Select handle = new Select(driver.findElement(By.name("handle_id")));
            handle.selectByVisibleText("Grande");
            Select control = new Select(driver.findElement(By.name("control_id")));
            control.selectByVisibleText("Electrico");
            Select canopy = new Select(driver.findElement(By.name("canopy_id")));
            canopy.selectByVisibleText("500");
            WebElement button =  driver.findElement(By.id("save_curtain"));
            button.submit();
            System.out.println("Cortina creada correctamente\n");
        } catch(org.openqa.selenium.NoSuchElementException e) {
            System.out.println("Formulario de cortina incompleto\n");
        }
    }
    
    static void testCurtainDetails(WebDriver driver) throws InterruptedException{
        try {
            Select model = new Select(driver.findElement(By.name("model_id")));
            model.selectByVisibleText("Modelo");
            Select cover = new Select(driver.findElement(By.name("cover_id")));
            cover.selectByVisibleText("Admin");
            Thread.sleep(1000);
            if (driver.getPageSource().contains("Ancho máximo:") && driver.getPageSource().contains("Uniones:")) {
                System.out.println("Detalles desplegados correctamente");
            } else {
                System.out.println("Detalles no desplegados");
            }
        } catch(org.openqa.selenium.NoSuchElementException e) {
            System.out.println("Formulario de creacion de orden incompleto\n");
        }
    }
    
    static void testCurtainValidation(WebDriver driver){
        try {
            WebElement button =  driver.findElement(By.id("save_curtain"));
            button.submit();
            if(driver.getCurrentUrl().contains("/curtain/add")) {
                System.out.println("Validación funcionando correctamente");
            } else {
                System.out.println("Validación no funciona");
            }
        } catch(org.openqa.selenium.NoSuchElementException e) {
            System.out.println("Formulario de creacion de orden incompleto");
        }
    }
    
    static void seeProducts(WebDriver driver) throws InterruptedException{
        Thread.sleep(1000);
        if (driver.getPageSource().contains("Productos")) {
            System.out.println("Productos en orden visibles");
        } else {
            System.out.println("Productos no visibles");
        }
    }
    
    static void editOrder(WebDriver driver) throws InterruptedException{
        try {
            WebElement button = driver.findElement(By.id("edit_order_modal"));
            button.click();
            Thread.sleep(1000);
            Select activity = new Select(driver.findElement(By.name("activity")));
            activity.selectByVisibleText("Pedido");
            WebElement edit = driver.findElement(By.id("edit_order"));
            edit.click();
            Thread.sleep(1000);
            if (driver.getPageSource().contains("Pedido")) {
                System.out.println("Orden editada correctamente");
            } else {
                System.out.println("Orden no fue editada");
            }
        } catch(org.openqa.selenium.NoSuchElementException e) {
            System.out.println("Formulario de edición de orden incompleto\n");
        }
    }
    
    static void addDataForSending(WebDriver driver) throws InterruptedException{
        try {
            WebElement button = driver.findElement(By.id("add_data_modal"));
            button.click();
            Thread.sleep(1000);
            Select inst = new Select(driver.findElement(By.name("installation_type")));
            inst.selectByVisibleText("Pared");
            Select mech = new Select(driver.findElement(By.name("mechanism_side")));
            mech.selectByVisibleText("Izquierdo");
            Select view = new Select(driver.findElement(By.name("view_type")));
            view.selectByVisibleText("Interior");
            WebElement add = driver.findElement(By.id("add_data"));
            add.click();
            Thread.sleep(1000);
            if (driver.getPageSource().contains("Datos guardados correctamente")) {
                System.out.println("Datos agregados correctamente");
            } else {
                System.out.println("Datos no fueron agregados");
            }
        } catch(org.openqa.selenium.NoSuchElementException e) {
            System.out.println("Formulario de creacion de orden incompleto\n");
        }
    }
    
    static void deleteProduct(WebDriver driver) throws InterruptedException{
        try {
            WebElement button = driver.findElement(By.id("delete_product_modal"));
            button.click();
            Thread.sleep(1000);
            WebElement delete = driver.findElement(By.id("delete_curtain"));
            delete.click();
            Thread.sleep(1000);
            if (driver.getPageSource().contains("Producto eliminado correctamente")) {
                System.out.println("Producto fue eliminado");
            } else {
                System.out.println("Producto no fue eliminado");
            }
        } catch(org.openqa.selenium.NoSuchElementException e) {
            System.out.println("No se encontraron los botones\n");
        }
    }
    
    static void deleteOrder(WebDriver driver) throws InterruptedException{
        try {
            WebElement button = driver.findElement(By.id("delete_order_modal"));
            button.click();
            Thread.sleep(1000);
            WebElement add = driver.findElement(By.id("delete_order"));
            add.click();
            Thread.sleep(1000);
            if (driver.getPageSource().contains("Orden eliminada correctamente")) {
                System.out.println("Orden fue eliminada");
            } else {
                System.out.println("Producto no fue eliminado");
            }
        } catch(org.openqa.selenium.NoSuchElementException e) {
            System.out.println("No se encontraron los botones\n");
        }
    }
}
