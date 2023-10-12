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
  images_link: string;
  featured: boolean;
  today_deal: boolean;
  product_slider: boolean;
  trendy: boolean;
  status: string;
  category: CategoryInterface | null;
  brand: BrandInterface | null;
  // warehouse: string;
  // pickup_point: string;
  // user: string;
}

export interface ProductsWithPagination {
  data: ProductInterface[];
  links: Link;
  meta: Meta;
}
