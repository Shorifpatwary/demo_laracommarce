interface Timestamps {
  created_at: string;
  updated_at: string;
}

interface Links {
  first: string;
  last: string;
  prev: string | null;
  next: string | null;
}
export interface Meta {
  current_page: number;
  from: number;
  last_page: number;
  links: {
    url: string | null;
    label: string;
    active: boolean;
  }[];
  path: string;
  per_page: number;
  to: number;
  total: number;
}

export interface CategoryInterface extends Timestamps {
  description: string;
  icon: null | string;
  id: number;
  image: null | string;
  name: string;
  parent_id: null | number;
  slug: string;
  products: ProductInterface[] | null;
}

export interface BrandInterface extends Timestamps {
  description: string;
  icon: null | string;
  id: number;
  image: null | string;
  name: string;
  parent_id: null | number;
  slug: string;
}

export interface ProductInterface extends Timestamps {
  id: number;
  name: string;
  slug: string;
  code: string;
  unit: string;
  tags: string[];
  color: string;
  size: string;
  video: string | null;
  purchase_price: number;
  selling_price: number;
  discount_price: number;
  stock_quantity: number;
  description: string;
  thumbnail: string;
  thumbnail_link: string;
  images: string[];
  images_link: string[];
  featured: boolean;
  today_deal: boolean;
  product_slider: boolean;
  trendy: boolean;
  status: string;
  average_rating: number;
  review: productReviewInterface[] | null;
  category: CategoryInterface | null;
  brand: BrandInterface | null;
  // warehouse: string;
  // pickup_point: string;
  // user: string;
}

export interface ProductsWithPagination {
  data: ProductInterface[];
  links: Links;
  meta: Meta;
}

interface UserInterface extends Timestamps {
  id: number;
  name: string;
  email: string;
  email_verified_at: string | null;
  phone: string | null;
  role_id: number;
}

export interface productReviewInterface extends Timestamps {
  id: number;
  body: string;
  rating: number;
  approved: boolean;
  featured: boolean;
  // Add other fields as needed
  product: ProductInterface | null;
  customer: CustomerInterface | null;
}
interface CustomerInterface extends Timestamps {
  id: number;
  name: string;
  email: string;
  phone: string | null;
  image: string | null;
  email_verified_at: string | null;
  birth_date: string | null;
  password: string;
  remember_token: string;
}
