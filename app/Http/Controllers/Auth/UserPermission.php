<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserPermission extends Controller
{
    public function servePermission()
    {
        $this->createRole();

        $superAdmin                   = Role::select()->where('name', 'super_admin')->first();
        $admin                        = Role::select()->where('name', 'admin')->first();
        $smgManager                   = Role::select()->where('name', 'smg_manager')->first();
        $rootSmgManager                   = Role::select()->where('name', 'root_smg_manager')->first();
        $sales_executive              = Role::select()->where('name', 'sales_executive')->first();
        $purchases_team               = Role::select()->where('name', 'purchases_team')->first();

        $userCreatePermission         = Permission::select()->where('name', 'user-create')->first();
        $userEditPermission           = Permission::select()->where('name', 'user-edit')->first();
        $userStatusUpdatePermission   = Permission::select()->where('name', 'user-status-update')->first();
        $userDeletePermission         = Permission::select()->where('name', 'user-delete')->first();
        $userViewPermission           = Permission::select()->where('name', 'user-view')->first();

        $orderCreatePermission        = Permission::select()->where('name', 'order-create')->first();
        $orderEditPermission          = Permission::select()->where('name', 'order-edit')->first();
        $orderViewPermission          = Permission::select()->where('name', 'order-view')->first();
        $orderStatusUpdatePermission  = Permission::select()->where('name', 'order-status-update')->first();
        $orderDeletePermission        = Permission::select()->where('name', 'order-delete')->first();

        $customerCreatePermission        = Permission::select()->where('name', 'customer-create')->first();
        $customerEditPermission          = Permission::select()->where('name', 'customer-edit')->first();
        $customerViewPermission          = Permission::select()->where('name', 'customer-view')->first();
        $customerStatusUpdatePermission  = Permission::select()->where('name', 'customer-status-update')->first();
        $customerDeletePermission        = Permission::select()->where('name', 'customer-delete')->first();

        $supplierCreatePermission        = Permission::select()->where('name', 'supplier-create')->first();
        $supplierEditPermission          = Permission::select()->where('name', 'supplier-edit')->first();
        $supplierViewPermission          = Permission::select()->where('name', 'supplier-view')->first();
        $supplierStatusUpdatePermission  = Permission::select()->where('name', 'supplier-status-update')->first();
        $supplierDeletePermission        = Permission::select()->where('name', 'supplier-delete')->first();

        $productCreatePermission        = Permission::select()->where('name', 'product-create')->first();
        $productEditPermission          = Permission::select()->where('name', 'product-edit')->first();
        $productViewPermission          = Permission::select()->where('name', 'product-view')->first();
        $productStatusUpdatePermission  = Permission::select()->where('name', 'product-status-update')->first();
        $productDeletePermission        = Permission::select()->where('name', 'product-delete')->first();

        $superAdmin->givePermissionTo([
            //user
            $userCreatePermission,
            $userEditPermission,
            $userDeletePermission,
            $userStatusUpdatePermission,
            $userViewPermission,
            //order
            $orderCreatePermission,
            $orderViewPermission,
            $orderEditPermission,
            $orderStatusUpdatePermission,
            $orderDeletePermission,
            // Customer
            $customerCreatePermission,
            $customerEditPermission,
            $customerViewPermission,
            $customerStatusUpdatePermission,
            $customerDeletePermission,

            // Product
            $productCreatePermission,
            $productEditPermission,
            $productViewPermission,
            $productStatusUpdatePermission,
            $productDeletePermission,

            //Supplier
            $supplierCreatePermission,
            $supplierEditPermission,
            $supplierViewPermission,
            $supplierStatusUpdatePermission,
            $supplierDeletePermission
        ]);

        $admin->givePermissionTo([
            //user
            $userCreatePermission,
            $userEditPermission,
            $userDeletePermission,
            $userStatusUpdatePermission,
            $userViewPermission,
            //order
            $orderCreatePermission,
            $orderViewPermission,
            $orderEditPermission,
            $orderStatusUpdatePermission,
            $orderDeletePermission,
            // Customer
            $customerCreatePermission,
            $customerEditPermission,
            $customerViewPermission,
            $customerStatusUpdatePermission,
            $customerDeletePermission,
            // Product
            $productCreatePermission,
            $productEditPermission,
            $productViewPermission,
            $productStatusUpdatePermission,
            $productDeletePermission,
            //Supplier
            $supplierCreatePermission,
            $supplierEditPermission,
            $supplierViewPermission,
            $supplierStatusUpdatePermission,
            $supplierDeletePermission,
        ]);

        $smgManager->givePermissionTo([
            //order
            $orderStatusUpdatePermission,
            //user
            $userCreatePermission,
            $userEditPermission,
            $userDeletePermission,
            $userViewPermission,
            $userStatusUpdatePermission,
            // Customer status update permission
            $customerStatusUpdatePermission,
            $customerViewPermission,
            $customerCreatePermission,
            $customerEditPermission,
            $customerDeletePermission,
            // Product
            $productCreatePermission,
            $productEditPermission,
            $productViewPermission,
            $productStatusUpdatePermission,
            $productDeletePermission,

            //Supplier
            $supplierCreatePermission,
            $supplierEditPermission,
            $supplierViewPermission,
            $supplierStatusUpdatePermission,
            $supplierDeletePermission,

        ]);

        $rootSmgManager->givePermissionTo([
            $userCreatePermission,
            $userEditPermission,
            $userDeletePermission,
            $userViewPermission,
        ]);

        $sales_executive->givePermissionTo([
            //user view
            $userViewPermission,
            //Product view Permission
            $productViewPermission,
            $productCreatePermission,
            $productEditPermission,
            $productDeletePermission,

            //order
            $orderCreatePermission,
            $orderEditPermission,
            $orderViewPermission,
            $orderDeletePermission,
            //customer
            $customerCreatePermission,
            $customerViewPermission,
            $customerEditPermission,
            $customerDeletePermission,
        ]);
        $purchases_team->givePermissionTo([
            //order
            $orderStatusUpdatePermission,
            $orderViewPermission,
            $userViewPermission,
            //Supplier
            $supplierCreatePermission,
            $supplierEditPermission,
            $supplierViewPermission,
            $supplierStatusUpdatePermission,
            $supplierDeletePermission,

        ]);

        return "Everything is okay";
    }

    public function createRole()
    {
        try {
            Role::create(['name' => 'super_admin']);
        } catch (Exception $e) {
        }

        try {
            Role::create(['name' => 'admin']);
        } catch (Exception $e) {
        }

        try {
            Role::create(['name' => 'smg_manager']);
        } catch (Exception $e) {
        }

        try {
            Role::create(['name' => 'root_smg_manager']);
        } catch (Exception $e) {
        }

        try {
            Role::create(['name' => 'purchases_team']);
        } catch (\Throwable $th) {
        }

        try {
            Role::create(['name' => 'sales_executive']);
        } catch (\Throwable $th) {
        }
        $this->createPermission();
    }

    public function createPermission()
    {
        /*
        * Permissioin for order part
        */
        $this->createOrderPermission();
        /*
        * Permissioin for User part
        */
        $this->createUserPermission();
        /*
        * Permissioin for Customer part
        */
        $this->createCustomerPermission();
        /*
        * Permissioin for Product part
        */
        $this->createProductPermission();
        /*
        * Permissioin for Product part
        */
        $this->createSupplierPermission();
    }

    public function createOrderPermission()
    {
        try {
            Permission::create(['name' => 'order-create']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'order-edit']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'order-view']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'order-delete']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'order-status-update']);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function createUserPermission()
    {
        try {
            Permission::create(['name' => 'user-create']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'user-edit']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'user-status-update']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'user-delete']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'user-view']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'user-show']);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function createCustomerPermission()
    {
        try {
            Permission::create(['name' => 'customer-create']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'customer-edit']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'customer-status-update']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'customer-delete']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'customer-view']);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function createProductPermission()
    {
        try {
            Permission::create(['name' => 'product-create']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'product-edit']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'product-status-update']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'product-delete']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'product-view']);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function createSupplierPermission()
    {
        try {
            Permission::create(['name' => 'supplier-create']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'supplier-edit']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'supplier-status-update']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'supplier-delete']);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            Permission::create(['name' => 'supplier-view']);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
