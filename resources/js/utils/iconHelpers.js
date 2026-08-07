/**
  * Helper functions for product emojis and differential icons.
  */

export const getProductEmoji = (name) => {
  const n = (name || '').toLowerCase();
  if (n.includes('peixe') || n.includes('filé') || n.includes('tambaqui')) return '🐟';
  if (n.includes('melão')) return '🍈';
  if (n.includes('melancia')) return '🍉';
  if (n.includes('manga')) return '🥭';
  if (n.includes('abacaxi')) return '🍍';
  if (n.includes('mamão')) return '🥭';
  if (n.includes('coco')) return '🥥';
  if (n.includes('banana')) return '🍌';
  if (n.includes('café')) return '☕';
  if (n.includes('uva')) return '🍇';
  if (n.includes('mandioca') || n.includes('macaxeira')) return '🥔';
  if (n.includes('abóbora')) return '🎃';
  if (n.includes('pimenta')) return '🌶️';
  return '🥬';
};

export const getDiffIcon = (title) => {
  const t = (title || '').toLowerCase();
  if (t.includes('sustentável') || t.includes('sustentavel')) return '🌿';
  if (t.includes('capacitação') || t.includes('capacitacao') || t.includes('manejo')) return '🎓';
  if (t.includes('comercial') || t.includes('apoio')) return '📦';
  if (t.includes('inov') || t.includes('tecnol')) return '💡';
  return '✓';
};
