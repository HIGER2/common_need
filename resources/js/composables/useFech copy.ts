import { ref, watchEffect } from "vue";

export function useFetch(url: string, method: string = "GET", data: any = null) {
  const response = ref<any>(null);
  const errors = ref<any>(null);
  const loading = ref<boolean>(false);

  const fetchData = async (newData: any = null) => {
    loading.value = true;
    response.value = null;
    errors.value = null;

    try {
      if (method.toUpperCase() === "GET") {
        const res = await window.axios.get(url, { params: newData ?? data });
        response.value = res.data;
      } else {
        const res = await window.axios({
          method,
          url,
          data: newData ?? data,
        });
        response.value = res.data;
      }
    } catch (error: any) {
      errors.value = error.response ? error.response.data : error;
    } finally {
      loading.value = false;
    }
  };

  // 👉 Lancer automatiquement uniquement pour GET
  if (method.toUpperCase() === "GET") {
    watchEffect(() => {
      if (url) fetchData();
    });
  }

  return {
    response,
    errors,
    loading,
    refetch: fetchData, // pour les POST / PUT / DELETE manuels
  };
}
