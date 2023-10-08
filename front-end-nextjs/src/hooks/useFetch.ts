import { useEffect, useState } from "react";

export type HTTPMethod = "GET" | "POST" | "PUT" | "DELETE";

interface UseFetchResponse<T> {
  data: T | null;
  error: string | null;
  isLoading: boolean;
  isComplete: boolean;
}

interface RequestOptions {
  headers?: { [key: string]: string };
  body?: any;
}

function useFetch<T>(
  url: string,
  method: HTTPMethod = "GET",
  options: RequestOptions = {}
): UseFetchResponse<T> {
  const [data, setData] = useState<T | null>(null);
  const [error, setError] = useState<string | null>(null);
  const [isLoading, setLoading] = useState<boolean>(false);
  const [isComplete, setIsComplete] = useState<boolean>(false);

  useEffect(() => {
    const fetchData = async () => {
      setLoading(true);
      setIsComplete(false);
      setError(null);

      try {
        const response = await fetch(url, {
          method,
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            ...options.headers,
          },
          body: JSON.stringify(options.body),
        });

        const responseData = await response.json();

        if (!response.ok) {
          setError(`HTTP Error: ${response.statusText}`);
        } else {
          setData(responseData.data);
        }
      } catch (error) {
        setError(error);
      } finally {
        setLoading(false);
        setIsComplete(true);
      }
    };

    fetchData();
  }, [url, method, options.headers, options.body]);

  return { data, error, isLoading, isComplete };
}

export default useFetch;
