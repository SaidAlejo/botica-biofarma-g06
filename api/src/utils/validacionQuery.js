export const LIMITE_MAXIMO = 50;

export const enteroPositivo = (valor, porDefecto) => {
  if (valor === undefined) return porDefecto;
  if (typeof valor !== "string" || valor.trim() === "") return null;
  const numero = Number(valor);
  return Number.isInteger(numero) && numero > 0 ? numero : null;
};

export const parsearId = (valor) => {
  const id = Number(valor);
  return Number.isSafeInteger(id) && id > 0 ? id : null;
};
