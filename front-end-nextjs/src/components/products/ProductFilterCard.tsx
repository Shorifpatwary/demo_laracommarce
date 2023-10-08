import React, { useEffect, useState } from "react";
import Accordion from "../accordion/Accordion";
import AccordionHeader from "../accordion/AccordionHeader";
import Avatar from "../avatar/Avatar";
import Card from "../Card";
import CheckBox from "../CheckBox";
import Divider from "../Divider";
import FlexBox from "../FlexBox";
import Rating from "../rating/Rating";
import TextField from "../text-field/TextField";
import { H5, H6, Paragraph, SemiSpan } from "../Typography";
import { useCategory } from "@context/CategoryProvider";
import { BrandInterface } from "interfaces/api-response";
import { brand } from "@data/apis";
import useFetch from "@hook/useFetch";
import { priceRangeType, ProductStatusOption } from "pages/product/search/[id]";

type ProductFilterCardProps = {
  priceRange: priceRangeType;
  setPriceRange: React.Dispatch<React.SetStateAction<priceRangeType>>;
  selectedBrands: BrandInterface[];
  setSelectedBrands: React.Dispatch<React.SetStateAction<BrandInterface[]>>;
  productStatus: ProductStatusOption[];
  setProductStatus: React.Dispatch<React.SetStateAction<ProductStatusOption[]>>;
  selectedRatings: number[];
  setSelectedRatings: React.Dispatch<React.SetStateAction<number[]>>;
};

const ProductFilterCard: React.FC<ProductFilterCardProps> = ({
  priceRange,
  setPriceRange,
  selectedBrands,
  setSelectedBrands,
  productStatus,
  setProductStatus,
  selectedRatings,
  setSelectedRatings,
}) => {
  const { parentCategories, childCategories, hasChildWithParentId } =
    useCategory();

  const [fetchedBrands, setFetchedBrands] = useState<BrandInterface[]>([]);

  // Update the parent component's brands state when the selected brands change
  const handleBrandSelection = (brand: BrandInterface) => {
    const isBrandSelected = selectedBrands.some(
      (selectedBrand) => selectedBrand.id === brand.id
    );

    if (isBrandSelected) {
      // Deselect the brand
      const updatedSelectedBrands = selectedBrands.filter(
        (selectedBrand) => selectedBrand.id !== brand.id
      );
      setSelectedBrands(updatedSelectedBrands);
    } else {
      // Select the brand
      setSelectedBrands([...selectedBrands, brand]);
    }
  };

  // get the brands for server
  const { data, error, isLoading, isComplete } = useFetch<BrandInterface[]>(
    brand.url, // Replace with the actual category URL
    brand.method
  );

  useEffect(() => {
    if (isComplete) {
      if (error) {
        console.error("Error:", error);
      } else {
        setFetchedBrands(data || []);
      }
    }
  }, [error, isComplete, isLoading]);

  return (
    <Card p="18px 27px" elevation={5}>
      <H6 mb="10px">Categories</H6>

      {parentCategories.map((item) =>
        childCategories(item.id) ? (
          <Accordion key={item.id} expanded>
            <AccordionHeader
              showIcon={hasChildWithParentId(item.id)}
              px="0px"
              py="6px"
              color="text.muted"
              // justifyContent="flex-start"
            >
              <SemiSpan className="cursor-pointer" mr="9px">
                {item.name}
              </SemiSpan>
            </AccordionHeader>
            {childCategories(item.id)?.map((childCategoryItem) => (
              <Paragraph
                className="cursor-pointer"
                fontSize="14px"
                color="text.muted"
                pl="22px"
                py="6px"
                key={childCategoryItem.id}
              >
                {childCategoryItem.name}
              </Paragraph>
            ))}
          </Accordion>
        ) : (
          <Paragraph
            className="cursor-pointer"
            fontSize="14px"
            color="text.muted"
            py="6px"
            key={item.name}
          >
            {item.name}
          </Paragraph>
        )
      )}

      <Divider mt="18px" mb="24px" />

      <H6 mb="16px">Price Range</H6>
      <FlexBox justifyContent="space-between" alignItems="center">
        <TextField
          placeholder="0"
          type="number"
          fullwidth
          value={priceRange.min}
          onChange={(e) =>
            setPriceRange({ ...priceRange, min: parseInt(e.target.value) })
          }
        />
        <H5 color="text.muted" px="0.5rem">
          -
        </H5>
        <TextField
          placeholder="250"
          type="number"
          fullwidth
          value={priceRange.max}
          onChange={(e) =>
            setPriceRange({ ...priceRange, max: parseInt(e.target.value) })
          }
        />
      </FlexBox>

      <Divider my="24px" />

      <H6 mb="16px">Brands</H6>
      {fetchedBrands?.map((brand) => (
        <CheckBox
          key={brand.id}
          name={brand.name}
          value={brand.id}
          color="secondary"
          label={<SemiSpan color="inherit">{brand.name}</SemiSpan>}
          my="10px"
          checked={selectedBrands.some(
            (selectedBrand) => selectedBrand.id === brand.id
          )}
          onChange={() => handleBrandSelection(brand)}
        />
      ))}

      <Divider my="24px" />

      <H6 mb="16px">Product Status</H6>
      {productStatus.map((statusOption) => (
        <CheckBox
          key={statusOption.name}
          name={statusOption.name}
          color="secondary"
          label={<SemiSpan color="inherit">{statusOption.label}</SemiSpan>}
          my="10px"
          onChange={(e) => {
            const selectedStatus = e.target.name;
            const updatedProductStatus = productStatus.map((option) =>
              option.name === selectedStatus
                ? { ...option, value: e.target.checked }
                : option
            );
            setProductStatus(updatedProductStatus);
          }}
          checked={statusOption.value}
        />
      ))}

      <Divider my="24px" />

      <H6 mb="16px">Ratings</H6>
      {[5, 4, 3, 2, 1].map((item) => (
        <CheckBox
          key={item}
          value={item}
          color="secondary"
          label={<Rating value={item} outof={5} color="warn" />}
          my="10px"
          onChange={(e) => {
            const ratingValue = parseInt(e.target.value, 10);
            const updatedRatings = selectedRatings.includes(ratingValue)
              ? selectedRatings.filter((rating) => rating !== ratingValue)
              : [...selectedRatings, ratingValue];
            setSelectedRatings(updatedRatings);
          }}
          checked={selectedRatings.includes(item)}
        />
      ))}

      <Divider my="24px" />

      {/* <H6 mb="16px">Colors</H6>
      <FlexBox mb="1rem">
        {colorList.map((item) => (
          <Avatar bg={item} size={25} mr="10px" style={{ cursor: "pointer" }} />
        ))}
      </FlexBox> */}
    </Card>
  );
};

const categroyList = [
  {
    title: "Bath Preparations",
    subCategories: ["Bubble Bath", "Bath Capsules", "Others"],
  },
  {
    title: "Eye Makeup Preparations",
  },
  {
    title: "Fragrance",
  },
  {
    title: "Hair Preparations",
  },
];

const brandList = ["Maccs", "Karts", "Baars", "Bukks", "Luasis"];
const otherOptions = ["On Sale", "In Stock", "Featured", "Trendy"];
const colorList = [
  "#1C1C1C",
  "#FF7A7A",
  "#FFC672",
  "#84FFB5",
  "#70F6FF",
  "#6B7AFF",
];

export default React.memo(ProductFilterCard);
