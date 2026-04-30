#include "../include/functions.hpp"

std::array<int, 4> to_binary(const int& number) {
  std::array<int, 4> bits;
  for (int i = 0; i < 4; i++) {
    bits[i] = (number >> (3 - i) & 1);
  }
  return bits;
}

int to_decimal(std::array<int, 4>& gruppo) {
  int decimale {};
  for (int i = 0; i < 4; i++) {
    decimale += gruppo[i] * (8 >> i);
  }
  return decimale;
}

std::array<int, 4> sbox(std::array<int, 4>& gruppo) {
  int index {to_decimal(gruppo)};
  std::array<int, 4> result {to_binary(TABELLA[index])};
  return result;
}

std::array<int, 8> convert_to_sbox(std::array<int, 8>& blocco) {
  std::array<int, 8> result {};
  std::array<int, 4> temp_gruppo {};
  int temp_index {}, result_index {};
  for (int i = 0; i < blocco.size(); i++) {
    temp_gruppo[temp_index++] = blocco[i];
    if (temp_index == 4) {
      std::array<int, 4> sbox_result = sbox(temp_gruppo);
      temp_index = {};
      for (int j = 0; j < sbox_result.size(); j++) {
        result[result_index++] = sbox_result[j];
      }
    }
  }
  return result;
}

