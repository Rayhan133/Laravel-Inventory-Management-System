import CategoryCreate from '../components/Category/CategoryCreate';
import CategoryIndex from '../components/Category/CategoryIndex';


 const routes = [
    {
        path : '/category/create',
        name: 'category.create',
        component : CategoryCreate
     },
    {
        path : '/category',
        name: 'category.index',
        component : CategoryIndex
     },
]

export default routes;
