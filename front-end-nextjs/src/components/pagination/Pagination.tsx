import React from "react";
import ReactPaginate from "react-paginate";
import { SpaceProps } from "styled-system";
import Button from "../buttons/Button";
import Icon from "../icon/Icon";
import { StyledPagination } from "./PaginationStyle";

export interface PaginationProps extends SpaceProps {
  pageCount: number;
  marginPagesDisplayed?: number;
  pageRangeDisplayed?: number;
  onChange?: (data: { selected: number }) => void;
  setPage: React.Dispatch<React.SetStateAction<number>>;
}

const Pagination: React.FC<PaginationProps> = ({
  pageCount,
  marginPagesDisplayed,
  pageRangeDisplayed,
  onChange,
  setPage,
  ...props
}) => {
  const handlePageChange = async (page) => {
    if (onChange) onChange(page.selected);
    setPage(page.selected + 1);
    console.log(page.selected + 1, "page.selected form pagination");
    console.log(page, "page form pagination");
  };

  return (
    <StyledPagination {...props}>
      <ReactPaginate
        previousLabel={
          <Button
            className="control-button"
            color="primary"
            overflow="hidden"
            height="auto"
            padding="6px"
            borderRadius="50%"
          >
            <Icon defaultcolor="currentColor" variant="small">
              chevron-left
            </Icon>
          </Button>
        }
        nextLabel={
          <Button
            className="control-button"
            color="primary"
            overflow="hidden"
            height="auto"
            padding="6px"
            borderRadius="50%"
          >
            <Icon defaultcolor="currentColor" variant="small">
              chevron-right
            </Icon>
          </Button>
        }
        breakLabel={
          <Icon defaultcolor="currentColor" variant="small">
            triple-dot
          </Icon>
        }
        pageCount={pageCount}
        marginPagesDisplayed={marginPagesDisplayed}
        pageRangeDisplayed={pageRangeDisplayed}
        onPageChange={handlePageChange}
        containerClassName="pagination"
        subContainerClassName="pages pagination"
        activeClassName="active"
        disabledClassName="disabled"
      />
    </StyledPagination>
  );
};

export default Pagination;
