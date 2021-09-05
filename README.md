# fashol

## All Module ##

###  Admin ###
1. first_name (required|)
2. last_name (nullable)
3. email (required|unique)
4. password (required|)
5. image (nullable)
6. mobile_number (unique)


###  SMG managar ###
1. admin_id(integer)
1. name (reqired)
2. email(unique|reqired)
3. phone(unique|reqired)
4. nid_image(nullable|reqired)
5. image(|reqired)
6. account_status(default(0))
7. password(|reqired)

### Sales executiv ###
1. smg_menager_id(Integer)
2. name (reqired)
3. email(unique|reqired)
4. phone(unique|reqired)
5. nid_image(|reqired)
6. image(|reqired)
7. password(|reqired)
###  Customer ###
1. sales_executive_id (integer)
2. zone_id(integer)
3. name 
4. email (nullable|unique)
5. phone(unique)
6. area (nullable)
7. city (nullable)
8. account_balance
9. account_due
10. address_line_1(nullable)
11. address_line_2(nullable)
12. image(nullable)
13. nid_image(nullable)
14. account_status
###  Supplier ###
1. purchase_team_id(integer)
2. zone_id(integer)
3. name 
4. email (nullable|unique)
5. phone(unique)
6. address_line_1(nullable)
7. address_line_2(nullable)
8. area (nullable)
9. city (nullable)
10. image(nullable)
11. nid_image(nullable)
12. account_balance
13. account_due
14. account_type
15. account_status


###  zone ###
1. name
###  zone Smg Manager ###
1. admin_id (integer)
2. zone_id (integer)
3. smg_manager_id(integer)

### categorie ###
1. smg_manager_id(integer)
2. name
### product ###
1. category_id(integer)
2. name
3. sku
4. unite
5. image
### product_variant ###
1. product_id(integer)
2. name
3. sku
### order ###
1. product_id(integer)
2. customer_id(integer)
3. sales_executive_id(integer)
4. product_quantity
### purchase_team ###
1. smg_manager_id(integer)
2. zone_id(integer)
3. name 
4. email (nullable|unique)
5. phone(unique)
6. address_line_1(nullable)
7. address_line_2(nullable)
8. image(nullable)
9. nid_image(nullable)
10. account_status
11. password
### supplier_historie ###
1. supplier_id (integer)
2. product_id (integer)
3. purchase_team_id (integer)
4. product_count
5. product_cost
### market_list ###
1. smg_manager_id (integer)
2. purchase_team_id (integer)
3. name
### delivery_for_customer ###
1. product_id(integer)
2. customer_id(integer)
3. sales_executive_id(integer)
4. product_quantity
5. product_cost
6. note 
 7. delivery_status(integer)
 ### customer_account_logs ###
 1.  customer_id(integer)
 2. delivery_for_customer_id(integer)
 3. sales_executive_id(integer)
 4. payment
 5. payment_due
