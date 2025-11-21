export const useFetch = async (
  url: string = "",
  method: string = "GET",
  data: any = null
) => {
  let response: any = null;
  let errors: any = null;

  try {

    if (method.toUpperCase() === "GET") {
      response = await window.axios.get('localhost:8000/'+url, { params: data });
    } else {
      response = await window.axios({
        method,
        url,
        data,
      });
    }
  } catch (error: any) {
    errors = error.response ? error.response.data : error;
  }

  return { response, errors };
};
