interface timestamps {
  created_at: string;
  updated_at: string;
}
export interface CategoryInterface extends timestamps {
  description: string;
  icon: null | string;
  id: number;
  image: null | string;
  name: string;
  parent_id: null | number;
  slug: string;
}
