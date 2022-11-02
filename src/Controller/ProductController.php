<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Entity\OrderDetail;
use App\Repository\OrderDetailRepository;
use App\Repository\OderRepository;
use App\Entity\Oder;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\Criteria;




    /**
     * @Route("/product")
     */
class ProductController extends AbstractController
{
    
    /**
     * @Route("/comments", name="app_product_comments")
     */
    public function comments(): Response
    {
        return $this->render('about/comments.html.twig');
    }
    /**
     * @Route("/home", name="app_product_home")
     */
    public function home(): Response
    {
        return $this->render('about/home.html.twig');
    }
     
    /**
     * @Route("/about", name="app_product_about")
     */
    public function about(): Response
    {
        return $this->render('about/about.html.twig');
    }
     
    /**
     * @Route("/contact", name="app_product_contact")
     */
    public function contact(): Response
    {
        return $this->render('about/contact.html.twig');
    }

    /**
     * @Route("/check", name="app_product_check")
     */
    public function check(): Response
    {
        return $this->render('about/check.html.twig');
    }

/**
 * @Route("/checkoutCart", name="app_checkout_cart", methods={"GET"})
 */
public function checkoutCart(Request               $request,
                                OrderDetailRepository $orderDetailRepository,
                                OderRepository       $orderRepository,
                                ProductRepository     $productRepository,
                                ManagerRegistry       $mr): Response
{
    $this->denyAccessUnlessGranted('ROLE_USER');
    $entityManager = $mr->getManager();
    $session = $request->getSession(); //get a session
    // check if session has elements in cart
    if ($session->has('cartElements') && !empty($session->get('cartElements'))) {
        try {
            // start transaction!
            $entityManager->getConnection()->beginTransaction();
            $cartElements = $session->get('cartElements');

            //Create new Order and fill info for it. (Skip Total temporarily for now)
            $order = new Oder();
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $order->setOrderDate(new \DateTime());
            /** @var \App\Entity\User $user */
            $user = $this->getUser();
            $order->setUser($user);
            $order->setTotalprice(0);
            $orderRepository->add($order, true); //flush here first to have ID in Order in DB.

            //Create all Order Details for the above Order
            $total = 0;
            foreach ($cartElements as $product_id => $quantity) {
                $product = $productRepository->find($product_id);
                //create each Order Detail
                $orderDetail = new OrderDetail();
                $orderDetail->setOrder($order);
                $orderDetail->setProduct($product);
                $orderDetail->setQuantity($quantity);
                $orderDetailRepository->add($orderDetail);

                $total += $product->getPrice() * $quantity;
            }
            $order->setTotalprice($total);
            $orderRepository->add($order);
            // flush all new changes (all order details and update order's total) to DB
            $entityManager->flush();

            // Commit all changes if all changes are OK
            $entityManager->getConnection()->commit();

            // Clean up/Empty the cart data (in session) after all.
            $session->remove('cartElements');
        } catch (Exception $e) {
            // If any change above got trouble, we roll back (undo) all changes made above!
            $entityManager->getConnection()->rollBack();
        }
        return new Response("Check in DB to see if the checkout process is successful");
    } else
        return new Response("Nothing in cart to checkout!");
}


    /**
     * @Route("/list/{pageId}", name="app_product_index", methods={"GET"})
     */
    public function index(Request $request, ProductRepository $productRepository,
    CategoryRepository $categoryRepository,
    int $pageId = 1): Response
    {
        $minPrice = $request->query->get('minPrice');
        $maxPrice = $request->query->get('maxPrice');
        $Cat = $request->query->get('category');
        // $search = $request->query->get('search');
        // $products = $productRepository->searching($search)->getResult();
        // $search = $request->query->get('search');
        // $query = $productRepository->findMore($search);
        // $product = $query->getResult();
        // $product = $productRepository->findMore($search);
        //-----------
        if(!(is_null($Cat)||empty($Cat))){
            $selectedCat=$Cat;  
        }
        else
        $selectedCat="";
        
        $tempQuery = $productRepository->findMore($minPrice, $maxPrice, $Cat);
        $pageSize = 8;


    // load doctrine Paginator
        $paginator = new Paginator($tempQuery);

    // you can get total items
        $totalItems = count($paginator);

    // get total pages
        $numOfPages = ceil($totalItems / $pageSize);
        
    // now get one page's items:
        $tempQuery = $paginator
        ->getQuery()
        ->setFirstResult($pageSize * ($pageId - 1)) // set the offset
        ->setMaxResults($pageSize); // set the limit
        
    $products =  $tempQuery->getResult();

        return $this->render('product/index.html.twig', [
            'products' =>  $products,
            'selectedCat' => $selectedCat,
            'categories' => $categoryRepository->findAll(),
            'numOfPages' => $numOfPages,
            'catNumber' => $Cat,
            'minP' => $minPrice,
            'maxP' => $maxPrice,
            'tongso'=>$totalItems
        ]);
    }

    
        /**
     * @Route("/addCart/{id}", name="app_add_cart", methods={"GET"})
     */
    public function addCart(Product $product, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $session = $request->getSession();
        // $rq = $request;
        $quantity = (int)$request->query->get('quantity');
        // dd($rq);
        //check if cart is empty
        if (!$session->has('cartElements')) {
            //if it is empty, create an array of pairs (prod Id & quantity) to store first cart element.
            $cartElements = array($product->getId() => $quantity);
            //save the array to the session for the first time.
            $session->set('cartElements', $cartElements);
        } else {
            $cartElements = $session->get('cartElements');
            //Add new product after the first time. (would UPDATE new quantity for added product)
            $cartElements = array($product->getId() => $quantity) + $cartElements;
            //Re-save cart Elements back to session again (after update/append new product to shopping cart)
            $session->set('cartElements', $cartElements);
        }
        //sau khi thêm sp vào thẳng giỏ hàng
        // return $this->redirectToRoute('app_review_cart', [], Response::HTTP_SEE_OTHER);
        return new Response(); //means 200, successful
        
    }

            /**
         * @Route("/reviewCart", name="app_review_cart", methods={"GET"})
         */
        public function reviewCart(Request $request): Response
        {
            $this->denyAccessUnlessGranted('ROLE_USER');
            $session = $request->getSession();
            if ($session->has('cartElements')) {
                $cartElements = $session->get('cartElements');
            } else
                $cartElements = [];
            // return $this->render('product/reviewCart.html.twig');
            return $this->json($cartElements);
        }       
        //chuyển hướng đến trang reviewCart
            // /**
            //  * @Route("/view", name="app_review_cart")
            //  */
            // public function show2(Request $request): Response
            // {
            //     return $this->render('product/reviewCart.html.twig');
            // }
            

    /**
     * @Route("/new", name="app_product_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProductRepository $productRepository): Response
    {
    
     $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $productImg = $form->get('Image')->getData();
            $product->setPublisher($user);
            if ($productImg) {
                $originExt = pathinfo($productImg->getClientOriginalName(), PATHINFO_EXTENSION);
                $newName = $product->getName() . '.' . $originExt;

                try {
                    $productImg->move(
                        $this->getParameter('product_directory'),
                        $newName
                    );
                } catch (FileException $e) {
                }
                $product->setImgUrl($newName);
                $productRepository->add($product, true);
            }

            $productRepository->add($product, true);
            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/plus", name="app_product_plus", methods={"GET"})
     */
    public function plus(Request $request): Response
    {
     $this->denyAccessUnlessGranted('ROLE_ADMIN');
     $firstNum = $request->query->get('a');
     $secondNum = $request->query->get('b');
     $Name = $request->query->get('name');
     return new Response(
        '<html><body>Tong: '.($firstNum + $secondNum).' welcome:'.($Name).'</body></html>'
     );

    }
    /**
     * @Route("/shownologin/{id}", name="app_product_showlogout", methods={"GET"})
     */
    public function showlogout(Product $product): Response
    {
        
        return $this->render('product/showlogout.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/showuser/{id}", name="app_product_showuser", methods={"GET"})
     */
    public function showuser(Product $product): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('product/showuser.html.twig', [
            'product' => $product,
        ]);
    }
    /**
     * @Route("/admin/{id}", name="app_product_showadmin", methods={"GET"})
     */
    public function showadmin(Product $product): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('product/showadmin.html.twig', [
            'product' => $product,
        ]);
    }
    /**
     * @Route("/{id}/edit", name="app_product_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->add($product, true);

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_product_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }
    
    /**
     * @Route("/admin", name="app_product_admin", methods={"GET"})
     */
    public function admin(ProductRepository $productRepository): Response
    {
        return $this->render('product/admin.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }
    /**
     * @Route("/admin", name="app_admin", methods={"POST"})
     */
    public function admin1(): Response
    {   
        $this->denyAccessUnlessGranted('ROLE_USER');
        

        return $this->redirectToRoute('admin.html.twig', [], Response::HTTP_SEE_OTHER);
    }
}